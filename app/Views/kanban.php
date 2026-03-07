<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal ToDo - Kanban</title>
    <!-- CSRF Token -->
    <?= csrf_meta() ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .kanban-board {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding-bottom: 1rem;
            min-height: 80vh;
        }

        .kanban-col {
            background: #e9ecef;
            border-radius: 8px;
            flex: 1;
            min-width: 300px;
            max-width: 400px;
            display: flex;
            flex-direction: column;
        }

        .kanban-col-header {
            padding: 1rem;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .kanban-col-body {
            padding: 0.5rem;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            min-height: 200px;
        }

        .task-card {
            cursor: grab;
            background: #fff;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            user-select: none;
        }

        .task-card:active {
            cursor: grabbing;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .task-card.dragging {
            opacity: 0.5;
        }

        .col-todo .kanban-col-header {
            border-bottom-color: #0d6efd;
        }

        .col-doing .kanban-col-header {
            border-bottom-color: #fd7e14;
        }

        .col-done .kanban-col-header {
            border-bottom-color: #198754;
        }

        .col-limbo .kanban-col-header {
            border-bottom-color: #6c757d;
        }

        .drag-over {
            background: #d1d6db;
            border: 2px dashed #adb5bd;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1"><i class="bi bi-kanban"></i> My ToDo Kanban</span>
            <button class="btn btn-primary btn-sm" onclick="openTaskModal()"><i class="bi bi-plus-lg"></i> Nova
                Tarefa</button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="kanban-board" id="kanban-board">
            <!-- Limbo Column -->
            <div class="kanban-col col-limbo">
                <div class="kanban-col-header text-secondary">Limbo (<span id="count-limbo">0</span>)</div>
                <div class="kanban-col-body" data-status="limbo"></div>
            </div>
            <!-- Todo Column -->
            <div class="kanban-col col-todo">
                <div class="kanban-col-header text-primary">Para Fazer (<span id="count-todo">0</span>)</div>
                <div class="kanban-col-body" data-status="todo"></div>
            </div>
            <!-- Doing Column -->
            <div class="kanban-col col-doing">
                <div class="kanban-col-header text-warning">Fazendo (<span id="count-doing">0</span>)</div>
                <div class="kanban-col-body" data-status="doing"></div>
            </div>
            <!-- Done Column -->
            <div class="kanban-col col-done">
                <div class="kanban-col-header text-success">Feito (<span id="count-done">0</span>)</div>
                <div class="kanban-col-body" data-status="done"></div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Nova Tarefa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm">
                        <input type="hidden" id="taskId">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label">Título</label>
                            <input type="text" class="form-control" id="taskTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskDesc" class="form-label">Descrição</label>
                            <textarea class="form-control" id="taskDesc" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Status Inicial</label>
                            <select class="form-select" id="taskStatus">
                                <option value="limbo">Limbo</option>
                                <option value="todo">Para Fazer</option>
                                <option value="doing">Fazendo</option>
                                <option value="done">Feito</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveTask()">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script>
        const API_URL = '/api/tasks';
        let taskModal;

        // Setup fetch interceptor to automatically add CSRF token
        const fetchApi = async (url, options = {}) => {
            const csrfName = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('name'); // Usually X-CSRF-TOKEN in CI4
            // Correct way to get the token name and hash in CI4:
            const tokenName = document.querySelector('meta[name="X-CSRF-TOKEN"]') ? 'X-CSRF-TOKEN' : csrfName;
            const tokenValue = document.querySelector('meta[name="X-CSRF-TOKEN"]').getAttribute('content');

            const headers = {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...(options.headers || {})
            };

            // CI4 expects X-CSRF-TOKEN header by default
            headers['X-CSRF-TOKEN'] = tokenValue;

            const response = await fetch(url, { ...options, headers });

            // Refresh token if a new one is returned in headers
            const newToken = response.headers.get('X-CSRF-TOKEN');
            if (newToken) {
                document.querySelector('meta[name="X-CSRF-TOKEN"]').setAttribute('content', newToken);
            }

            return response;
        };

        document.addEventListener("DOMContentLoaded", () => {
            // Fix CSRF Meta for fetch interceptor logic
            const csrfMeta = document.querySelector('meta[name="X-CSRF-TOKEN"]');
            if (!csrfMeta) {
                // Because csrf_meta() might output <meta name="csrf_test_name" content="...">
                // we will find it generally by looking at the first meta tag after title, but let's be safe:
                const metaTags = document.querySelectorAll('meta');
                metaTags.forEach(m => {
                    if (m.getAttribute('name') && m.getAttribute('name').includes('csrf')) {
                        m.setAttribute('name', 'X-CSRF-TOKEN'); // Standardize for our fetch
                    }
                });
            }

            taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
            loadTasks();
            setupDragAndDrop();
        });

        async function loadTasks() {
            try {
                const res = await fetchApi(API_URL);
                const data = await res.json();

                // Clear columns
                document.querySelectorAll('.kanban-col-body').forEach(col => col.innerHTML = '');

                let counts = { limbo: 0, todo: 0, doing: 0, done: 0 };

                data.forEach(task => {
                    counts[task.status]++;
                    renderTaskCard(task);
                });

                // Update badges
                document.getElementById('count-limbo').textContent = counts.limbo;
                document.getElementById('count-todo').textContent = counts.todo;
                document.getElementById('count-doing').textContent = counts.doing;
                document.getElementById('count-done').textContent = counts.done;

            } catch (error) {
                console.error("Error loading tasks", error);
                Swal.fire('Erro!', 'Não foi possível carregar as tarefas.', 'error');
            }
        }

        function renderTaskCard(task) {
            const col = document.querySelector(`.kanban-col-body[data-status="${task.status}"]`);
            if (!col) return;

            const card = document.createElement('div');
            card.className = 'task-card card mb-2';
            card.draggable = true;
            card.dataset.id = task.id;

            const descHtml = task.description ? `<p class="card-text text-muted small mb-2 text-truncate">${escapeHtml(task.description)}</p>` : '';

            card.innerHTML = `
            <div class="card-body p-2">
                <h6 class="card-title fw-semibold mb-1">${escapeHtml(task.title)}</h6>
                ${descHtml}
                <div class="d-flex justify-content-end gap-2 mt-2">
                     <button class="btn btn-sm btn-outline-secondary py-0 px-2" onclick="editTask(${task.id})" title="Editar"><i class="bi bi-pencil"></i></button>
                     <button class="btn btn-sm btn-outline-danger py-0 px-2" onclick="deleteTask(${task.id})" title="Excluir"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        `;

            // Drag events
            card.addEventListener('dragstart', handleDragStart);
            card.addEventListener('dragend', handleDragEnd);

            col.appendChild(card);
        }

        function escapeHtml(unsafe) {
            return (unsafe || '').toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function openTaskModal() {
            document.getElementById('taskForm').reset();
            document.getElementById('taskId').value = '';
            document.getElementById('taskModalLabel').textContent = 'Nova Tarefa';
            taskModal.show();
        }

        async function editTask(id) {
            try {
                const res = await fetchApi(`${API_URL}/${id}`);
                const task = await res.json();

                document.getElementById('taskId').value = task.id;
                document.getElementById('taskTitle').value = task.title;
                document.getElementById('taskDesc').value = task.description || '';
                document.getElementById('taskStatus').value = task.status;

                document.getElementById('taskModalLabel').textContent = 'Editar Tarefa';
                taskModal.show();
            } catch (error) {
                Swal.fire('Erro!', 'Falha ao carregar a tarefa.', 'error');
            }
        }

        async function saveTask() {
            const id = document.getElementById('taskId').value;
            const payload = {
                title: document.getElementById('taskTitle').value,
                description: document.getElementById('taskDesc').value,
                status: document.getElementById('taskStatus').value
            };

            if (!payload.title) {
                return Swal.fire('Atenção', 'O título é obrigatório.', 'warning');
            }

            const method = id ? 'PUT' : 'POST';
            const url = id ? `${API_URL}/${id}` : API_URL;

            try {
                const res = await fetchApi(url, {
                    method: method,
                    body: JSON.stringify(payload)
                });
                const data = await res.json();

                if (res.ok) {
                    taskModal.hide();
                    loadTasks();
                } else {
                    Swal.fire('Erro!', data.messages ? Object.values(data.messages).join('<br>') : 'Erro ao salvar.', 'error');
                }
            } catch (error) {
                Swal.fire('Erro!', 'Falha de comunicação com a API.', 'error');
            }
        }

        async function deleteTask(id) {
            const result = await Swal.fire({
                title: 'Tem certeza?',
                text: "Esta tarefa será removida!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#secondary',
                confirmButtonText: 'Sim, excluir!'
            });

            if (result.isConfirmed) {
                try {
                    const res = await fetchApi(`${API_URL}/${id}`, { method: 'DELETE' });
                    if (res.ok) {
                        loadTasks();
                    } else {
                        Swal.fire('Erro!', 'Falha ao excluir.', 'error');
                    }
                } catch (error) {
                    Swal.fire('Erro!', 'Falha de comunicação com a API.', 'error');
                }
            }
        }

        // --- Drag and Drop Logic ---
        let draggedCard = null;

        function handleDragStart(e) {
            draggedCard = this;
            setTimeout(() => this.classList.add('dragging'), 0);
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        }

        function handleDragEnd(e) {
            this.classList.remove('dragging');
            document.querySelectorAll('.kanban-col-body').forEach(col => col.classList.remove('drag-over'));
            draggedCard = null;
        }

        function setupDragAndDrop() {
            const columns = document.querySelectorAll('.kanban-col-body');

            columns.forEach(col => {
                col.addEventListener('dragover', e => {
                    e.preventDefault();
                    col.classList.add('drag-over');
                });

                col.addEventListener('dragleave', e => {
                    col.classList.remove('drag-over');
                });

                col.addEventListener('drop', async e => {
                    e.preventDefault();
                    col.classList.remove('drag-over');

                    if (draggedCard) {
                        const newStatus = col.dataset.status;
                        const taskId = draggedCard.dataset.id;
                        const oldCol = draggedCard.closest('.kanban-col-body');

                        // Se moveu para a mesma coluna, ignore
                        if (oldCol === col) return;

                        // Move in DOM immediately for fast feedback
                        col.appendChild(draggedCard);

                        // Update API
                        try {
                            const res = await fetchApi(`${API_URL}/${taskId}`, {
                                method: 'PUT',
                                body: JSON.stringify({ status: newStatus })
                            });

                            if (!res.ok) {
                                throw new Error("API falhou");
                            }
                            // Reload fully to ensure counts and data consistency
                            loadTasks();
                        } catch (error) {
                            // Revert on error
                            oldCol.appendChild(draggedCard);
                            Swal.fire('Erro!', 'Não foi possível alterar o status.', 'error');
                        }
                    }
                });
            });
        }
    </script>

</body>

</html>
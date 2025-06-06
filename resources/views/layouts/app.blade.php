<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistema Oficina</title>
    
    <!-- Fontes e Ícones -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --dark-color: #1b263b;
            --light-color: #f8f9fa;
            --success-color: #4cc9f0;
            --danger-color: #f72585;
            --warning-color: #f8961e;
            --info-color: #43aa8b;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        /* Navbar */
        .navbar-custom {
            background-color: var(--dark-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
        }
        
        .navbar-custom .navbar-brand {
            font-weight: 600;
            color: white;
            font-size: 1.25rem;
        }
        
        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            margin: 0 2px;
            font-size: 0.9rem;
        }
        
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-custom .nav-link i {
            margin-right: 6px;
        }
        
        /* Cards */
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .card-header-custom {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
            border: none;
        }
        
        /* Botões */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Tabelas */
        .table-custom {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }
        
        .table-custom thead {
            background-color: var(--dark-color);
            color: white;
        }
        
        .table-custom th {
            font-weight: 500;
            padding: 1rem;
        }
        
        .table-custom td {
            padding: 0.75rem 1rem;
            vertical-align: middle;
        }
        
        .table-custom tbody tr {
            transition: background-color 0.2s ease;
        }
        
        .table-custom tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        /* Formulários */
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }
        
        .form-label {
            font-weight: 500;
            color: #555;
            margin-bottom: 0.5rem;
        }
        
        /* Alertas */
        .alert-custom {
            border-radius: 8px;
            padding: 1rem;
            border: none;
        }
        
        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 2rem 0;
        }
        
        
        
        /* Responsividade */
        @media (max-width: 992px) {
            .navbar-custom .navbar-nav {
                padding-top: 1rem;
            }
            
            .navbar-custom .nav-link {
                margin: 2px 0;
            }
            
            .back-arrow {
                top: 80px;
            }
        }
        
        @media print {
            .no-print {
                display: none;
            }
            
            .card {
                border: none;
                box-shadow: none;
            }
        }
        /* Dropdowns */
.navbar .dropdown-menu {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-radius: 8px;
    margin-top: 8px;
}

.dropdown-item {
    padding: 0.5rem 1.25rem;
    border-radius: 6px;
    margin: 2px 8px;
    width: auto;
}

.dropdown-item:hover {
    background-color: var(--primary-color);
    color: white;
}

.dropdown-divider {
    margin: 0.5rem 0;
}

.btn-outline-light {
    border-color: rgba(255,255,255,0.2);
    color: rgba(255,255,255,0.85);
    transition: all 0.3s ease;
}

.btn-outline-light:hover {
    border-color: white;
    color: white;
    background-color: rgba(255,255,255,0.1);
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.gap-3 {
    gap: 1rem !important;
}
    </style>
    
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-car me-2"></i> Oficina Mecânica
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Clientes Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-users me-1"></i> Clientes
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('clientes.create') }}">
                            <i class="fas fa-plus me-2"></i>Novo Cliente
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('clientes.search') }}">
                            <i class="fas fa-search me-2"></i>Buscar Clientes
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('clientes.index') }}">
                            <i class="fas fa-list me-2"></i>Lista Completa
                        </a></li>
                    </ul>
                </li>

                <!-- Veículos Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-car me-1"></i> Veículos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('veiculos.create') }}">
                            <i class="fas fa-plus me-2"></i>Novo Veículo
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('veiculos.search') }}">
                            <i class="fas fa-search me-2"></i>Buscar Veículos
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('veiculos.index') }}">
                            <i class="fas fa-list me-2"></i>Lista Completa
                        </a></li>
                    </ul>
                </li>

                <!-- Serviços Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-tools me-1"></i> Serviços
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('servicos.create') }}">
                            <i class="fas fa-plus me-2"></i>Novo Serviço
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('servicos.index') }}">
                            <i class="fas fa-search me-2"></i>Buscar Serviços
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('relatorios.servicos') }}">
                            <i class="fas fa-file-alt me-2"></i>Relatórios
                        </a></li>
                    </ul>
                </li>

                <!-- Relatórios -->
                <li class="nav-item">
                    <a href="{{ route('relatorios.faturamento') }}" class="nav-link">
                        <i class="fas fa-chart-line me-1"></i> Relatórios
                    </a>
                </li>

                <!-- Orçamentos Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-file-invoice me-1"></i> Orçamentos
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('orcamentos.create') }}">
                            <i class="fas fa-plus me-2"></i>Novo Orçamento
                        </a></li>
                        <li><a class="dropdown-item" href="{{ route('orcamentos.index') }}">
                            <i class="fas fa-list me-2"></i>Lista de Orçamentos
                        </a></li>
                    </ul>
                </li>
            </ul>

            <!-- Controles do Lado Direito -->
            <!-- Controles do Lado Direito -->
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('configuracoes.edit') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-cog me-1"></i>
                </a>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">
                        <i class="fas fa-sign-out-alt me-1"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

    <!-- Botão de Voltar -->
    <a href="javascript:history.back()" class="back-arrow">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container-fluid px-4">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    @stack('scripts')
</body>
</html>
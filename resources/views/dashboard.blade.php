<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Loja de Brinquedos - Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .highlight {
            background-color: #e0ffe0;
            font-weight: bold;
        }

        .missing-letter {
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Painel da Loja de Brinquedos</h1>

        <div class="card mb-4">
            <div class="card-body">
                <form id="loginForm" class="row g-3">
                    <div class="col-md-5">
                        <input type="email" id="authEmail" class="form-control" placeholder="E-mail" required />
                    </div>
                    <div class="col-md-5">
                        <input type="password" id="authPassword" class="form-control" placeholder="Senha" required />
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form id="clientForm" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="Nome completo" required />
                    </div>
                    <div class="col-md-4">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required />
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="birthdate" class="form-control" required />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
                    </div>
                </form>
            </div>
        </div>

        <h3>Resumo de Vendas por Dia</h3>
        <canvas id="salesChart" class="mb-5"></canvas>

        <div class="mb-4">
            <h4>Destaques</h4>
            <div id="topClients" class="row"></div>
        </div>

        <div id="clientes"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let token = '';
        const apiBase = 'http://127.0.0.1:8000/api';

        const primeiraLetraAusente = (nome) => {
            if (!nome || typeof nome !== 'string') return '-';
            const usado = new Set(nome.toLowerCase().replace(/[^a-z]/g, ''));
            for (let i = 97; i <= 122; i++) {
                const letra = String.fromCharCode(i);
                if (!usado.has(letra)) return letra;
            }
            return '-';
        };

        const normalizarClientes = (clientes) => clientes.map((c) => {
            const nome = c.info?.nomeCompleto;
            const email = c.info?.detalhes?.email;
            const nascimento = c.info?.detalhes?.nascimento;
            const vendas = c.estatisticas?.vendas || [];
            return { nome, email, nascimento, vendas };
        });

        const renderClientes = (clientes) => {
            const container = document.getElementById('clientes');
            container.innerHTML = '<h3>Lista de Clientes</h3>';

            clientes.forEach(c => {
                const card = document.createElement('div');
                card.className = 'card mb-3';
                card.innerHTML = `
        <div class="card-body">
          <h5 class="card-title">${c.nome}</h5>
          <p class="card-text mb-1"><strong>Email:</strong> ${c.email}</p>
          <p class="card-text mb-1"><strong>Nascimento:</strong> ${c.nascimento}</p>
          <p class="card-text mb-1"><strong>Vendas:</strong> ${c.vendas.length > 0 ? c.vendas.map(v => `R$${v.valor} (${v.data})`).join(', ') : 'Nenhuma'}</p>
          <p class="card-text mb-1"><strong>Letra ausente:</strong> <span class="missing-letter">${primeiraLetraAusente(c.nome)}</span></p>
        </div>
      `;
                container.appendChild(card);
            });
        };

        const renderTopClients = (dados) => {
            const container = document.getElementById('topClients');
            container.innerHTML = '';
            const map = {
                top_volume: 'Maior Volume de Vendas',
                top_average: 'Maior Média por Venda',
                top_frequency: 'Maior Frequência de Compra'
            };
            for (let key in dados) {
                const col = document.createElement('div');
                col.className = 'col-md-4';
                col.innerHTML = `
        <div class="alert alert-success">
          <h6>${map[key]}</h6>
          <p><strong>Cliente:</strong> ${dados[key]?.client?.name || 'Desconhecido'}</p>
        </div>
      `;
                container.appendChild(col);
            }
        };

        const renderChart = (vendas) => {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const labels = vendas.map(v => v.date);
            const data = vendas.map(v => v.total);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{ label: 'Total por Dia', data }]
                },
                options: { responsive: true }
            });
        };

        const carregarDados = async () => {
            const headers = { Authorization: `Bearer ${token}` };

            const clientesRes = await fetch(`${apiBase}/clients`, { headers });
            const clientesData = await clientesRes.json();
            renderClientes(normalizarClientes(clientesData.data.clientes));

            const estatRes = await fetch(`${apiBase}/statistics/top-clients`, { headers });
            const estat = await estatRes.json();
            renderTopClients(estat);

            const chartRes = await fetch(`${apiBase}/statistics/daily-sales`, { headers });
            const chartData = await chartRes.json();
            renderChart(chartData);
        };

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('authEmail').value;
            const password = document.getElementById('authPassword').value;
            try {
                const response = await fetch(`${apiBase}/login`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const result = await response.json();
                if (response.ok && result.token) {
                    token = result.token;
                    Swal.fire({
                        icon: 'success',
                        title: 'Login realizado com sucesso!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    carregarDados();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao fazer login',
                        text: result.message || 'Verifique suas credenciais.',
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de conexão',
                    text: 'Não foi possível conectar ao servidor.'
                });
            }
        });

        document.getElementById('clientForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const payload = Object.fromEntries(formData.entries());
            try {
                const response = await fetch(`${apiBase}/clients`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${token}`
                    },
                    body: JSON.stringify(payload)
                });
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente cadastrado com sucesso!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    carregarDados();
                } else {
                    const result = await response.json();
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro ao cadastrar cliente',
                        text: result.message || 'Verifique os dados e tente novamente.'
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de conexão',
                    text: 'Não foi possível cadastrar o cliente.'
                });
            }
        });
    </script>
</body>

</html>

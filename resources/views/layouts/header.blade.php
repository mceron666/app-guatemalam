<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Dinámico</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
    <div id="navbar">
        <img src="/images/image.webp" alt="Logo">
        <button id="inicio" onclick="selectNav('inicio'); loadPage('/')"><i class="fas fa-home"></i> Inicio</button>
        <button id="periodos" onclick="selectNav('periodos'); loadPage('/periodos')"><i class="fas fa-calendar-alt"></i> Períodos Escolares</button>
        <button id="maestros" onclick="selectNav('maestros'); loadPage('/maestros')"><i class="fas fa-users"></i> Maestros</button>
        <button id="alumnos" onclick="selectNav('alumnos'); loadPage('/alumnos')"><i class="fas fa-users"></i> Alumnos</button>
        <button id="materias" onclick="selectNav('materias'); loadPage('/materias')"><i class="fas fa-book"></i> Materias Escolares</button>
        <button id="grados" onclick="selectNav('grados'); loadPage('/grados')"><i class="fas fa-graduation-cap"></i> Grados y Carreras</button>
        <button id="bloques" onclick="selectNav('bloques'); loadPage('/bloques')"><i class="fas fa-th-large"></i> Bloques</button>
    </div>
    <div id="content"> 
        @yield("contenido")
    </div>
    <script>
    function loadPage(route) {
        axios.get(route, { headers: { "X-Requested-With": "XMLHttpRequest" } })
            .then(response => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(response.data, "text/html");

                // Mantener la tabla de usuarios si existe
                let tablaUsuarios = document.getElementById("tablaUsuarios");
                if (tablaUsuarios) {
                    let nuevaTabla = doc.getElementById("tablaUsuarios");
                    if (nuevaTabla) {
                        nuevaTabla.innerHTML = tablaUsuarios.innerHTML;
                    }
                }

                document.getElementById('content').innerHTML = doc.body.innerHTML;
                window.history.pushState({}, '', route);

                // Vuelve a cargar los usuarios si la tabla existe
                if (document.getElementById("tablaUsuarios")) {
                    fetchUsuarios();
                }
            })
            .catch(error => {
                console.error('Error al cargar la página:', error);
            });
    }

    function selectNav(id) {
        document.querySelectorAll('#navbar button').forEach(btn => btn.classList.remove('selected'));
        document.getElementById(id).classList.add('selected');
    }

    window.onpopstate = () => {
        const currentPath = window.location.pathname;
        loadPage(currentPath);
    };

    document.addEventListener('DOMContentLoaded', () => {
        loadPage(window.location.pathname);
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>

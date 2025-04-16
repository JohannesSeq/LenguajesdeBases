<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-aEtUUnHNeH44U0ibnCDEY8EoVoUIutV1kzMX7Mk9ihpO1D8k5T0yA5UjL+yJ/hC9p2VgBoN2kF4mN4qT2sqo1g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<footer class="site-footer">
  <div class="container">
    <div class="row">
      <?php if (isset($_COOKIE["permiso"])): ?>
      <div class="col-sm-12 col-md-6">
        <h6>Sobre el sistema</h6>
        <p class="text-justify">Este sistema fue diseñado para facilitar la gestión del restaurante Playa Cacao, permitiendo a los usuarios hacer pedidos, visualizar menús y a los empleados gestionar el negocio eficientemente.</p>
      </div>

      <div class="col-xs-6 col-md-3">
        <h6>Enlaces útiles</h6>
        <ul class="footer-links">
          <li><a href="index.php">Inicio</a></li>
          <?php if ($_COOKIE["permiso"] == "Limitado"): ?>
            <li><a href="mostrarMenu.php">Ver Menú</a></li>
            <li><a href="agregarPedido.php">Hacer Pedido</a></li>
          <?php elseif ($_COOKIE["permiso"] == "Parcial" || $_COOKIE["permiso"] == "Completo"): ?>
            <li><a href="listadoFacturas.php">Facturas y Pedidos</a></li>
            <li><a href="mostrarPlatillos.php">Inventario</a></li>
          <?php endif; ?>

          <?php if ($_COOKIE["permiso"] == "Completo"): ?>
            <li><a href="mostrarPersonas.php">Gestión de Personal</a></li>
            <li><a href="agregarEmpleado.php">Agregar Empleado</a></li>
          <?php endif; ?>
        </ul>
      </div>
      <?php endif; ?>

      <div class="col-xs-6 col-md-3">
        <h6>Redes Sociales</h6>
        <ul class="footer-links">
        <li><a class="facebook" href="https://www.facebook.com/PlayaCacao" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
        <li><a class="instagram" href="https://www.instagram.com/playacacao_beach/" target="_blank"><i class="fab fa-instagram"></i></a></li>
        </ul>
      </div>
    </div>
    <hr>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-6 col-xs-12">
        <p class="copyright-text">© 2025 Playa Cacao Restaurant. Todos los derechos reservados.</p>
      </div>

      <div class="col-md-4 col-sm-6 col-xs-12">
        <ul class="social-icons">
        <li><a class="facebook" href="https://www.facebook.com/PlayaCacao" target="_blank"><i class="fa fa-facebook-f"></i></a></li>
        <li><a class="instagram" href="https://www.instagram.com/playacacao_beach/" target="_blank"><i class="fab fa-instagram"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>


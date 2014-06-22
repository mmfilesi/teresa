<nav id="sidebar" class="inlineBlock caja">
    
        <div id="main-logo" class="caja">
            Nombre del sitio
            <span>o</span>
        </div>

        <h5>Imágenes</h5>
            <ul>
                <li>
                    <?php if ( $selected != 'subirImagen') { ?>
                        <a href="<?= base_url(); ?>admin/addImagen">Subir</a>
                    <?php } else { ?>
                        <span class="enlacesSeleccionados">Subir</span>
                    <?php } ?>
                </li>
                <li>
                    <?php if ( $selected != 'editarImagen' && $selected != 'editarImagenes') { ?>
                        <a href="<?= base_url(); ?>admin/imagenes">Editar</a></li>
                    <?php } else { ?>
                         <span class="enlacesSeleccionados">Editar</span>
                    <?php } ?>
            </ul>

        <h5>Álbumes</h5>
            <ul>
                <li><a href="<?= base_url(); ?>admin/addAlbum">Crear</a></li>
                <li><a href="<?= base_url(); ?>admin/albumes">Editar</a></li>
                <li><a href="<?= base_url(); ?>admin/ordenarAlbumes">Ordenar</a></li>
            </ul>
               
        <h5>Páginas</h5>
             <ul>
                <li>Editar</li>
            </ul>

        <h5>Admin</h5>
            <ul>
                <li><a href="<?= base_url(); ?>admin/ajustes">Ajustes</a></li>
                <li><a href="<?= base_url(); ?>admin/menu">Menú</a></li>
                <li>Usuarios</li>
            </ul>
</nav>

<script>

/*
$(function() {
    $( "#sidebar" ).accordion();
  }); */

</script>
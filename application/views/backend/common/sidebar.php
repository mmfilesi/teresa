<nav id="sidebar" class="inlineBlock caja">
    
        <div id="main-logo" class="caja">
            Nombre del sitio
            <span>o</span>
        </div>

        <h5>Imágenes</h5>
            <ul>
                <li><a href="<?= base_url(); ?>admin/addImagen">Subir</a></li>
                <li><a href="<?= base_url(); ?>admin/imagenes">Editar</a></li>
            </ul>

        <h5>Albums</h5>
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
                <li>Usuarios</li>
            </ul>
</nav>

<script>

/*
$(function() {
    $( "#sidebar" ).accordion();
  }); */

</script>
<nav id="sidebar" class="inlineBlock caja">
    
        <div id="main-logo" class="caja">
            Nombre del sitio
            <span>o</span>
        </div>

        <h5>Imágenes</h5>
            <ul>
                <li>
                    <?php if ( $selected != 'subirImagen' ) { ?>
                        <a href="<?= base_url(); ?>admin/addImagen">Subir</a>
                    <?php } else { ?>
                        <span class="enlacesSeleccionados">Subir</span>
                    <?php } ?>
                </li>
                <li>
                    <?php if ( $selected != 'editarImagen' && $selected != 'editarImagenes' ) { ?>
                        <a href="<?= base_url(); ?>admin/imagenes">Editar</a>
                    <?php } else { ?>
                         <span class="enlacesSeleccionados">Editar</span>
                    <?php } ?>
                </li>
                <li>Etiquetas</li>
            </ul>

        <h5>Álbumes</h5>
            <ul>
                <li>
                <?php if ( $selected != 'crearAlbum' ) { ?>
                        <a href="<?= base_url(); ?>admin/addAlbum">Crear</a>
                <?php } else { ?>
                         <span class="enlacesSeleccionados">Crear</span>
                <?php } ?>               
                </li>
                <li>
                <?php if ( $selected != 'editarAlbum' && $selected != 'editarAlbumes' ) { ?>
                       <a href="<?= base_url(); ?>admin/albumes">Editar</a>
                <?php } else { ?>
                         <span class="enlacesSeleccionados">Editar</span>
                <?php } ?>
                </li>               
                <li>
                <?php if ( $selected != 'ordenarAlbumes' ) { ?>
                        <a href="<?= base_url(); ?>admin/ordenarAlbumes">Ordenar</a>
                <?php } else { ?>
                         <span class="enlacesSeleccionados">Ordenar</span>
                <?php } ?>
                </li>
                <li>Categorías</li>
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
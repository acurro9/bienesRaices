

<fieldset>
            <legend>Información General</legend>
            <label for="titulo">Título: </label>
            <input type="text" id="titulo" placeholder="Titulo propiedad" name="titulo" value="<?php echo s($propiedad->titulo);?>">

            <label for="precio">Precio: </label>
            <input type="number" id="precio" placeholder="Precio propiedad" name="precio" value="<?php echo s($propiedad->precio);  ?>">
            
            <label for="habitaciones">Habitaciones: </label>
            <input type="number" id="habitaciones" placeholder="Habitaciones propiedad" name="habitaciones" value="<?php echo s($propiedad->habitaciones);  ?>">

            <label for="wc">WC: </label>
            <input type="number" id="wc" placeholder="Wc propiedad" name="wc" value="<?php echo s($propiedad->wc);  ?>">

            <label for="estacionamiento">Estacionamiento: </label>
            <input type="number" id="estacionamiento" placeholder="Estacionamiento propiedad" name="estacionamiento" value="<?php echo s($propiedad->estacionamiento);  ?>">

            <label for="imagen">Imagen: </label>
            <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png">
            
            <label for="descripcion">Descripción: </label>
            <textarea type="text" id="descripcion" placeholder="Descripcion propiedad" name="descripcion" ><?php echo s($propiedad->descripcion);  ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedores_id">
                <option value="">--Seleccione--</option>
                <?php while ($vendedor=mysqli_fetch_assoc($result)){?>
                    <option <?php echo s($propiedad->vendedores_id)==$vendedor['id']?'selected':''; ?> value="<?php echo $vendedor['id'];?>">
                        <?php  echo $vendedor['nombre']. " ".$vendedor['apellidos'];  ?>
                    </option>
                <?php } ?>
            </select>
        </fieldset>
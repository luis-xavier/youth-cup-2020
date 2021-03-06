<?php 
include "header.php";
if(isset($_SESSION) ){
    //$_POST = array();
}
var_dump($_SESSION);
?>


<link rel="stylesheet" type="text/css" href="css/formulario.css">

<div id="back_form">
<section id="form-wrapper">
	<h1>Registra a tu equipo</h1>
    <p><b>Estás a unos pasos de mostrar tu talento en Munich.</b><br>Llena el siguiente formulario para que podamos validar tu información e inscribir a tu equipo.</p>
    <form action="functions/contacto.php" method="POST" id="formulario" class="formulario">            
        <ul>
            <li>
                <input id="nombre_equipo" maxlength="50" name="nombre_equipo" size="20" type="text" required="" class="sinvalidar" onBlur="validarNombreEquipo('nombre_equipo')" oninput="validarNombreEquipo('nombre_equipo')"/>
                <label for="nombre_equipo">Nombre del equipo</label>
            </li>

            <li>
                <label for="afiliacion" class="select-label">Afiliación</label>
                <select  id="afiliacion" name="afiliacion" title="afiliacion" class="sinvalidar" onchange="validarSelectAfiliacion('afiliacion')">
                    <option value=""></option>
                    <option value="escuela">Escuela</option>
                    <option value="club">Club</option>
                    <option value="independiente">Independiente</option>
                    <option value="otro">Otro</option>
                </select>
            </li>

            <li>
                <input id="direccion" maxlength="80" name="direccion" size="20" type="text" required="" class="sinvalidar" onBlur="validarDireccion('direccion')" oninput="validarDireccion('direccion')"/>
                <label for="direccion">Dirección</label>
            </li>

            <li class="half-columnA">
                <input id="pais" maxlength="80" name="pais" size="20" type="text" required="" class="sinvalidar" onBlur="validarPais('pais')" oninput="validarPais('pais')"/>
                <label for="pais">País</label>
            </li>

            <li class="half-columnB">
                <input id="ciudad" maxlength="80" name="ciudad" size="20" type="text" required="" class="sinvalidar" onBlur="validarCiudad('ciudad')" oninput="validarCiudad('ciudad')"/>
                <label for="ciudad">Ciudad</label>
            </li>

            <li class="half-columnA">
                <input id="cp" maxlength="5" name="cp" size="20" type="text" required="" class="sinvalidar" onBlur="validarCP('cp')" oninput="validarCP('cp')" onkeypress="return isNumberKey(event)"/>
                <label for="cp">Código postal</label>
            </li>

            <li class="half-columnB">
                <input id="telefono" maxlength="13" name="telefono" size="20" type="text" required="" class="sinvalidar" onBlur="validarTelefono('telefono')" oninput="validarTelefono('telefono')" onkeypress="return isNumberKey(event)"/>
                <label for="telefono">Teléfono</label>
            </li>

            <li>
                <input id="nombre" maxlength="50" name="nombre" size="20" type="text" required="" class="sinvalidar" onBlur="validarNombre('nombre')" oninput="validarNombre('nombre')"/>
                <label for="nombre">Nombre de contacto</label>
            </li>

            <li>
                <input id="email" maxlength="80" name="email" size="20" type="text" required="" class="sinvalidar" onBlur="validarCorreo('email')" oninput="validarCorreo('email')" />
                <label for="email">Correo electrónico</label>
            </li>
        
           <li>
                <label for="yourrelation" class="select-label">Tu relación con el equipo</label>
                <select  id="yourrelation" name="yourrelation" title="yourrelation" class="sinvalidar" onchange="validarSelectTuRelacion('yourrelation')">
                    <option value=""></option>
                    <option value="coach">Coach</option>
                    <option value="coordinador">Coordinador</option>
                    <option value="director">Director</option>
                    <option value="jugador">Jugador</option>
                    <option value="familiar">Miembro de la familia</option>
                    <option value="otro">Otro</option>
                </select>
            </li>

            <li>
                <label for="enteraste" class="select-label">¿Cómo te enteraste del torneo?</label>
                <select  id="enteraste" name="enteraste" title="enteraste" class="sinvalidar" onchange="validarSelectEnteraste('enteraste')">
                    <option value=""></option>
                    <option value="television">Televisión</option>
                    <option value="internet">Internet</option>
                    <option value="amigos">Amigos</option>
                    <option value="facebook">Facebook</option>
                    <option value="otro">Otros</option>
                </select>
            </li>

            <li>
                <label for="reasontoregister" class="select-label">¿Porqué te registras en el torneo?</label>
                <select  id="reasontoregister" name="reasontoregister" title="reasontoregister" class="sinvalidar" onchange="validarSelectReasonToRegister('reasontoregister')">
                    <option value=""></option>
                    <option value="premios">Premios</option>
                    <option value="viaje">Posibilidad de viajar a Munich</option>
                    <option value="visores">Visores del Bayern Munich</option>
                    <option value="prestigio">Prestigio del torneo</option>
                    <option value="fechas">Las fechas</option>
                    <option value="otro">Otro</option>
                </select>
            </li>
            <li style="text-align: left;">
                <input type="checkbox" class="checkbox-estilizado" name="aviso" id="aviso" onchange="validarCheckAviso('aviso')">
                <label for="aviso">Acepto términos y condiciones contenidos en el <a href="aviso-privacidad.php" class="inline-link">Aviso de privacidad</a></label>
            </li>
        </ul>

        <button type="submit" name="enviar" onclick="validacion()" class="boton">ENVIAR</button>

    </form>

</section>
</div>

<?php include "footer.php" ?>

<script type="text/javascript" src="js/formulario.js"></script>

<?php include "modal.php" ?>
<?php require 'menu.php'; ?>
<main class="w3-row-padding w3-container ">
    <div class="w3-col s6 w3-mobile w3-section ">
        <div class="w3-container fcolor-d2 ">
            <h2>Ingresar datos del Cliente</h2>
        </div>
        <form class="w3-card " action="guardarcli.php" method="post">
            <div class="w3-row-padding">
                <div class="w3-third">
                    <label for="ccod" class="w3-label f-color-texto"><b>Codigo</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="text" 
                    placeholder="Id del cliente" id="ccod" name="ccodigo" required autofocus>
                </div>
                <div class="w3-twothird">
<label for="nalum" class="w3-label f-color-texto"><b>Nombre</b></label>
<input class="w3-input w3-border fcolor-l5" type="text" id="nalum"
name="cnomcliente" placeholder="Nombre del cliente" required>
                </div>
                <div class="w3-row-padding">
                    <label for="cdirec" class="w3-label f-color-texto"><b>Direccion</b></label>
                    <textarea class="w3-input w3-border fcolor-l5" id="cdirec"
                    name="cdireccion" placeholder="Direccion"></textarea>
                </div>
                <div class="w3-half">
                    <label for="ctel" class="w3-label f-color-texto"><b>Telefono Residencial</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="tel" id="ctel"
                    name="ctelcasa" placeholder="Telefono residencial" required>
                </div>
                <div class="w3-half">
                    <label for="ccel" class="w3-label f-color-texto"><b>Celular</b></label>
                    <input class="w3-input w3-border fcolor-l5" type="tel" id="ccel"
                    name="ccelular" placeholder="Telefono celular">
                </div>
                <div class="w3-row-padding">
<label for="cemail" class="w3-label f-color-texto"><b>Email</b></label>
<input class="w3-input w3-border fcolor-l5" type="tel" id="cemail"
name="cemail" placeholder="Correo electronico">
                </div>
                <button class="w3-btn w3-blue-grey w3-section" name="cguardar">Guardar</button>
            </div>
        </form>
    </div>

    <div class="w3-col s6 w3-mobile w3-section">
        <table class="w3-table w3-table-all w3-hoverable w3-striped">
            <thead>
                <tr class="fcolor-l1">
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'manipularcli.php';
                $listaclientes= modificarcliente::ConsultarClientes();
                foreach ($listaclientes as $cliente) { ?>
                <tr>
                    <td> <?php echo $cliente-> idcli; ?></td>
                    <td> <?php echo $cliente-> nomcli; ?></td>
               <td>
                <a href="editcli.php?idcli=<?php echo $cliente-> idcli ?>" class="w3-btn w3-teal">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="eliminacli.php?id=<?php echo $cliente->idcli ?>" class="w3-btn w3-red">
                    <i class="fas fa-user-times"></i>
</a>
               </td>
</tr>
<?php
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
<?php require 'pie_pagina.php';?>
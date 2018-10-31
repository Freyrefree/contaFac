
<?php
include('../Models/model.clientes.php');
$busquedacombo = new Cliente();

// if(isset($_POST["pais"]) && !empty($_POST["pais"]))
// {
//      $busquedacombo->set("pais",addslashes(utf8_decode($_POST['pais'])));
//      $answer=$busquedacombo->buscarComboEstado();
//       echo '<option value="">Estado</option>';
//        while ($row = mysqli_fetch_array($answer))
//        {    
//           echo "<option value='" . $row['c_estado'] . "'>" .utf8_encode($row['c_nombre_estado']) . "</option>";
//        } 



// }

if(isset($_POST["estadoupdate"]) && !empty($_POST["estadoupdate"]))
{
    $busquedacombo->set("estado",addslashes(utf8_decode($_POST['estadoupdate'])));    
    $answer=$busquedacombo->buscarComboMunicipio();
     echo '<option value="">Municipio</option>';      
       while ($row = mysqli_fetch_array($answer))
       {
                 //echo "<option value='" .$row['rowid']."-". $row['c_municipio'] . "'>" .$row['rowid']."-". $row['c_municipio'] . "</option>";
          //echo "<option value='" .$row['rowid']."-". $row['c_municipio'] . "'>" .utf8_encode($row['c_nombre_municipio']) . "</option>";
          echo "<option value='" . $row['c_municipio'] . "'>" .utf8_encode($row['c_nombre_municipio']) . "</option>";
      
          
       }
}

if((isset($_POST["municipioupdate"]) && !empty($_POST["municipioupdate"])) and (isset($_POST["estadomunupdate"]) && !empty($_POST["estadomunupdate"])) )
{
  //list($rowid, $municipio) = explode("-", $_POST['municipio'], 2);
    $busquedacombo->set("municipio",addslashes(utf8_decode($_POST['municipioupdate'])));
  //$busquedacombo->set("municipio",utf8_decode($municipio));
     $busquedacombo->set("estado",addslashes(utf8_decode($_POST['estadomunupdate'])));    
      $answer=$busquedacombo->buscarComboCodigoPostal();
       echo '<option value="">Código Postal</option>';      
         while ($row = mysqli_fetch_array($answer))
       {
                 
          echo "<option value='" . $row['c_cp'] . "'>" .utf8_encode($row['c_cp']) . "</option>";
      
          
       }
}

if(isset($_POST["codigopostalupdate"]) && !empty($_POST["codigopostalupdate"]))
{
    $busquedacombo->set("codigopostal",addslashes(utf8_decode($_POST['codigopostalupdate'])));    
    $answer=$busquedacombo->buscarComboColonia();
     echo '<option value="">Colonia</option>';      
       while ($row = mysqli_fetch_array($answer))
       {
                 
          echo "<option value='" . $row['rowid'] . "'>" .utf8_encode($row['c_nombre_colonia']) . "</option>";
      
          
       }
}

?>
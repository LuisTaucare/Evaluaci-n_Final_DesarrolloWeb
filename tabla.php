<?php
  include('conexion.php'); 

    echo'<hr>';
    echo '<html>';
    echo '  <head></head>';
    echo '  <body>';
    echo '      <h1>Formularisos</h1>';
    echo '      <table border="1">';

            echo'           <tr>';
            $i = 0;
            $r = $busqueda->rowCount();//cantidad de registros de la tabla en la bd
            //utilizar ISSET para detectar el boton presionado del formulario;
            if(isset($_POST['agregar'])){//como detectamos el boton presionado
                //consulta a la tabla carrito
                //insert o update
    
        
                
                //consultar si el producto existe en el carrito
                //no existe --> insertarlo rowcount =0
                //si existe --> actualizarlo rowcount > 0
                $sql=$cnx->prepare("SELECT * FROM carrito WHERE codigo_pro=".$_POST['codigo_pro']." AND estado_id = 'A' ");
                $sql->execute();
                if($sql->rowCount()==0){
                    //INSERT del producto
                
                    $sql2=$cnx->prepare("INSERT INTO carrito (pro_cantidad , codigo_pro, precio, carrito_fechahora, estado_id, precio_cantidad, usuario_carrito)
                    VALUES (1,".$_POST['codigo_pro'].",".$_POST['precio'].",'".$fechayhora."','A',".$_POST['precio'].",1)");
                    $sql2->execute(); 
                }else if($sql->rowCount()>0){
                    
                    //UPDATE la cantidad del registro de ese producto de 1 en 1
                    $sql3=$cnx->prepare("UPDATE carrito SET pro_cantidad = pro_cantidad + 1, precio_cantidad = pro_cantidad*precio WHERE codigo_pro =".$_POST['codigo_pro']."");
                    $sql3->execute();
                }

                
            }else{
                
            }
            
         
            
            foreach ($resultado as $muestra){
                $i++;
            
                   
            if($i <= $r ){
                echo' <form action="tabla.php" method="POST">';    
                echo'               <td>
                                        <table border="1">
                                            <tr>
                                                <td colspan="2">Código: '.$muestra['codigo_pro'].'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Descripción: '.$muestra['nombre'].'</td>
                                            </tr>
                                            <tr>
                                                <td>$'.$muestra['precio'].'</td>
                                                <td>Stock: '.$muestra['pro_stock'].'</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">imagen</td>
                                            </tr>
                                            <tr>
                                                <td>Fabricante: '.$muestra['codigo_fabricante'].'</td>
                                                <td><input type="submit" name="agregar" value="agregar"></td>
                                            </tr>
                                        </table>
                                    </td>';
                //input oculto
               
                echo'<input type="hidden" name="codigo_pro" value="'.$muestra['codigo_pro'].'"/>';
                echo'<input type="hidden" name="precio" value="'.$muestra['precio'].'"/>';

                echo' </form>';
                    // }
                    if($i%3 == 0){
                echo'           </tr>';
                
                    };
            }
        };  
            echo '      </table>';
            echo '<td>';
 
            $encontrar=$cnx->prepare("SELECT* FROM carrito WHERE estado_id= 'A'");
            $encontrar->execute();
            $vista = $encontrar->fetchAll();
            echo '<br><br><br>';
            echo' <form action="tabla.php" method="POST">';
            echo '<table border="1"> ';
            echo '<tr>';
            
            echo '<th>carrito_id</th>';
            echo '<th>pro_cantidad</th>';
            echo '<th>codigo_pro</th>';
            echo '<th>precio</th>';
            echo '<th>carrito_fechahora</th>';
            echo '<th>estado_id</th>';
            echo '<th>precio_cantidad</th>';
            echo '<th>usuario_carrito</th>';
            echo '<tr>';

            echo '<tr>';
            $c = 0;
            foreach ($vista as $mostrar){
                $c++;
            
            

            echo '<td>'.$mostrar['carrito_id'].'</td>';
            echo '<td>'.$mostrar['pro_cantidad'].'</td>';
            echo '<td>'.$mostrar['codigo_pro'].'</td>';
            echo '<td>$'.$mostrar['precio'].'</td>';
            echo '<td>'.$mostrar['carrito_fechahora'].'</td>';
            echo '<td>'.$mostrar['estado_id'].'</td>';
            echo '<td>$'.$mostrar['precio_cantidad'].'</td>';
            echo '<td>'.$mostrar['usuario_carrito'].'</td>';           
            
            
            
            if($c%1 == 0){
            echo '</tr>';
            echo'<br>';
        }
    }
    echo '<table border="1"> ';
    $o=$cnx->prepare("SELECT SUM(precio_cantidad) FROM carrito WHERE estado_id= 'A'");
    $o->execute();
    $ver = $o->fetchAll();
    
    foreach($ver as $sumatotal){
        echo '<tr>';
        echo '<th>Total a pagar</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>$'.$sumatotal['SUM(precio_cantidad)'].'</td>';
        echo '</tr>';
        echo '<br>';
        

    }
    echo '</table>';
    echo '<input type="hidden" name="pro_cantidad" value="'.$mostrar['pro_cantidad'].'"/>';
    echo '<input type="hidden" name="codigo_pro" value="'.$mostrar['codigo_pro'].'"/>';
    echo '<input type="submit" name="comprar" value="comprar">';
    echo '</td>';
    echo' </form>';
    if(isset($_POST['comprar'])){

        $sql25=$cnx->prepare("INSERT INTO compras (total_compras, fechahora_compras, estado_compras, usuario_compras)
        VALUES (".$sumatotal['SUM(precio_cantidad)'].",'".$fechayhora."','A',1)");
        $sql25->execute();
    
    
        foreach($vista as $ojo){
        

            $sql0=$cnx->prepare("UPDATE producto SET pro_stock = pro_stock - ".$ojo['pro_cantidad']." WHERE codigo_pro =".$ojo['codigo_pro']."");
            $sql0->execute();

            

            $sql12=$cnx->prepare("DELETE FROM carrito");
            $sql12->execute();

        }
    }
            echo '  </body>';
            echo '</html>';
            
        ?>

     
<?php

    require "conexaoMysql.php";

    session_start();
    $mysqli = conectaAoMySQL();


    //consultar no banco de dados
    $result_produto    = "SELECT * FROM Produto ORDER BY codigo DESC";
    $resultado_produto = mysqli_query($mysqli, $result_produto);
    

    //Verificar se encontrou resultado na tabela "usuarios"
    if (($resultado_produto) and ($resultado_produto->num_rows != 0)) {
?>

<div class="row">
<?php
    while ($row_produto = mysqli_fetch_assoc($resultado_produto)) {
?>

    <style>
        #div_produtos {
            padding: 20px;
        }
        
        #thumb_produto {
            height: 400px;
        }
    </style>

    <div class="col" id="div_produtos">
        <div id="thumb_produto" class="img-thumbnail">
            <div class="caption text-center">
                <style>
                    #img_produtos {
                        width: 200px;
                        height: 200px;
                    }
                    a.link {
                        display: block;
                        height: 100%;
                        width: 100%;
                        text-decoration: none;
                    }
                </style>

                <a href="detalhes.php?id=<?= $row_produto['codigo'] ?>">
                    <img src="<?=$row_produto['pro_img']?>" alt="..." id="img_produtos">
                </a>
                
                <h5><?php echo $row_produto['nome']; ?></h5>
                <h5>R$ <?php echo $row_produto['preco_venda']; ?></h5>
               
                        
                        <a class="btn btn-primary" class="card-link" onclick="addCarrinho()">Comprar</a>
                        
            </div>
        </div>
    </div>
    <?php
    }//fim while
    ?>
</div>
<?php
}//fim do if 
else {
    echo "<div class='alert alert-danger' role='alert'>Nenhum Produto encontrado!</div>";

}//fim do else
?>   

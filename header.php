<header> <!-- Inicio Header -->
    <nav><!-- Inicio Navegação -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <!-- Botão que acolhe todos os link quando diminui a tela -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-principal">
                <span class="navbar-toggler-icon"></span>
            </button>
             
            <!-- Links a serem recolhidos -->
            <div class="collapse navbar-collapse" id="nav-principal">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="navbar-brand" href="index.php"><img src="imagens/logo.png" alt="logo" style="width:80px;"><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesquisar.php?pesquisar=bicicletas">Bicicletas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesquisar.php?pesquisar=componentes">Componentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesquisar.php?pesquisar=acessorios">Acessórios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesquisar.php?pesquisar=vestuario">Vestuário</a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <!-- Botão para abrir a janela modal ENTRAR-->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalEntrar">
                            Entrar
                    </button>
                        
                    <!-- Modal -->
                    <div class="modal fade" id="modalEntrar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Insira os seus dados para realizar login.</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="container">
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="login">Login:</label> <br>
                                                    <input class="form-control" name="login" type="email" placeholder="ex: xxx@gmail.com" required>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="senha">Senha:</label><br>
                                                    <input class="form-control" name="senha" type="password" placeholder="senha" required>
                                                </div>
                                            </div>
                                            <br>    
                                            <div class="row">
                                                <button class="btn btn-success" type="submit">Entrar</button>
                                            </div>    
                                        </form>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-success m-2" href="cadastraCliente.php">Cadastrar</a>
                    
                    <a class="btn btn-success" href="areacliente.php">Bem Vindo Sr(a) <?=  $_SESSION['nomeCliente']?></a>

                    <!-- Botão para abrir a janela modal Carrinho-->
                    <a href="#" class="btn btn-outline-dark ml-2" data-toggle="modal" data-target="#modalCarrinho">
                        <i class="fa fa-shopping-cart"></i>
                    </a>

                    <!-- Modal -->
                    <div class="modal fade" id="modalCarrinho">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Seu carrinho de compras</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="form-group row text-center">
                                            <div class="form-group col-md-12">
                                                <table class="table table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Produto</th>
                                                        <th>Valor</th>
                                                        <th>#</th>
                                                      </tr>
                                                    </thead>
                                                    
                                                    <tbody>
                                                        <tr>
                                                            <td><?= $pedido->id ?></td>
                                                            <td><?= $pedido->cliente ?></td>
                                                            <td><i class="fas fa-check-square fa-lg text-danger" onclick="concluirCompra()"> </i></td>
                                                        </tr> 
                                                    </tbody>
                                                </table>            
                                            </div>
                                        </div>
                                        <div>
                                            <button class="btn btn-success">Comprar</button>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
    </nav>
</header><!-- Fim Header -->
<?php require('app/views/partials/head.admin.php') ?>

<div id="main" class="container-fluid">
    <main>
        <h1 class="mt-4 mx-auto non-space">Listagem de Produtos</h1>

        <button class="mt-4 mb-4 btn btn-warning btn-lg non-space" data-toggle="modal" data-target="#new">Adicionar Novo Produto</button>

        <?php
        if (isset($_SESSION['sucessos']))
            foreach ($_SESSION['sucessos'] as $sucesso) : ?>
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Sucesso!</strong> <?= $sucesso ?>
            </div>
        <?php endforeach ?>

        <?php
        if (isset($_SESSION['erros']))
            foreach ($_SESSION['erros'] as $erro) : ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Erro!</strong> <?= $erro ?>
            </div>
        <?php endforeach ?>

        <?php
        unset($_SESSION['sucessos']);
        unset($_SESSION['erros']);
        ?>


        <div class="card mb-4 w-auto">
            <div class="card-header">
                <div class="row mb-1">
                    <div class="col-sm-12">
                        <h4 class="ml-2 non-space">Produtos</h4>
                    </div>
                </div>
                <div id="second-line" class="row">
                    <div class="col-sm-10">
                        <div class="mr-auto barra-pesquisa">
                            <form action="/admin/produto" method="GET" class="form-group form-navbar">
                                <div class="input-group">
                                    <input type="text" name="Pesquisa" class="form-control" placeholder="Pesquisar">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered no-space" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nome do produto</th>
                                        <th>Preço do produto</th>
                                        <th>Categoria</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nome do produto</th>
                                        <th>Preço do produto</th>
                                        <th>Categoria</th>
                                        <th>Ação</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <?php
                                    $produtoQNT = 0;
                                    foreach ($produtos as $produto) :
                                    ?>
                                        <?php if ($produtoQNT < $pagina * 9 && $produtoQNT >= ($pagina - 1) * 9) : ?>
                                            <tr>
                                                <td><?= $produto->name; ?></td>
                                                <td><?= $produto->price; ?></td>

                                                <td>
                                                    <?php
                                                    foreach ($categorias as $categoria) : ?>

                                                        <?php if ($categoria->id == $produto->id_category) : ?>
                                                            <?= $categoria->name; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </td>

                                                <td>
                                                    <button type="button" class="btn" data-toggle="modal" data-target="#view-product-<?= $produto->id; ?>"><i class="fas fa-eye"></i></button>
                                                    <button type="button" class="btn" data-toggle="modal" data-target="#edit-<?= $produto->id; ?>"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn" data-toggle="modal" data-target="#delete-<?= $produto->id; ?>"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        <?php endif;
                                        $produtoQNT++; ?>

                                        <!--MODAIS DO BOOTSTRAP-->
                                        <!--deletar-->
                                        <div class="modal" id="delete-<?= $produto->id; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirmação para deletar</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Você confirma que deseja deletar o produto: <?= $produto->name; ?></p>
                                                        <p>Esta ação é irrevessível</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="/admin/produto/delete" method="POST">
                                                            <input type="hidden" name="id" value="<?= $produto->id; ?>">
                                                            <input type="hidden" name="foto" value="<?= $produto->image; ?>">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                            <button class="btn btn-danger">Confirmar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--view-product-->
                                        <div class="modal view-product-admin" id="view-product-<?= $produto->id; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Visualizar</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="view-product-container">
                                                            <img src="<?= $produto->image; ?>" alt="Produto">
                                                            <div class="view-product-information">
                                                                <h1><?= $produto->name; ?></h1>
                                                            </div>
                                                            <div class="view-product-information">
                                                                <?php foreach ($categorias as $categoria) : ?>
                                                                    <?php if ($categoria->id == $produto->id_category) : ?>
                                                                        <h6><?= $categoria->name; ?></h6>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <div class="view-product-information">
                                                                <h5>R$ <?= $produto->price; ?></h4>
                                                            </div>
                                                            <div class="view-product-information">
                                                                <p><?= $produto->description; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!--Edit-->
                                        <div class="modal" id="edit-<?= $produto->id; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content formulario-produto-admin">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar Produto</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form action="/admin/produto/edit" method="POST" enctype="multipart/form-data">
                                                            <div class="form-group">
                                                                <input type="hidden" name="item_id" value="<?= $produto->id; ?>">
                                                                <input type="hidden" name="foto" value="<?= $produto->image; ?>">
                                                                <h5>Nome do produto</h5>
                                                                <input type="text" name="item_name" class="form-control" value="<?= $produto->name; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <h5>Preço(R$)</h5>
                                                                <input type="text" name="item_price" class="form-control" value="<?= $produto->price; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <h5>Estoque</h5>
                                                                <input type="text" name="item_stock" class="form-control" value="<?= $produto->stock; ?>">
                                                            </div>

                                                            <div class="form-group">
                                                                <h5>Descrição</h5>
                                                                <input type="text" name="item_description" class="form-control" value="<?= $produto->description; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <h5>Categoria</h5>
                                                                <select class="form-control" name="item_category" id="exampleFormControlSelect1">
                                                                    <?php
                                                                    foreach ($categorias as $categoria) : ?>

                                                                        <?php if ($categoria->id == $produto->id_category) : ?>
                                                                            <option value="<?= $categoria->id; ?>" selected="selected">
                                                                                <?= $categoria->name; ?>
                                                                            </option>
                                                                        <?php endif; ?>

                                                                        <?php if ($categoria->id != $produto->id_category) : ?>
                                                                            <option value="<?= $categoria->id; ?>">
                                                                                <?= $categoria->name; ?>
                                                                            </option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <h5>Foto</h5>
                                                                <input class="form-control" type="file" name="item_image">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                <button class="btn btn-success">Editar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php

                            function unset_uri_var($variable, $uri)
                            {
                                $parseUri = parse_url($uri);
                                $arrayUri = array();
                                parse_str($parseUri['query'], $arrayUri);
                                unset($arrayUri[$variable]);
                                $newUri = http_build_query($arrayUri);
                                $newUri = $parseUri['path'] . '?' . $newUri;
                                return $newUri;
                            }

                            //Anterior e posterior
                            $anterior = $pagina - 1;
                            $posterior = $pagina + 1;
                            ?>

                            <nav class="nav justify-content-end">
                                <?php if ($anterior != 0) : ?>

                                    <?php if (isset($_GET) && !empty($_GET) && ((isset($_GET['Pesquisa']) && !empty($_GET['Pesquisa'])) || (isset($_GET['Categoria']) && !empty($_GET['Categoria'])))) :
                                        $url = unset_uri_var('pagina', basename($_SERVER['REQUEST_URI']));
                                    ?>
                                        <li class="page-item"><a class="page-link produtos-paginas" href="<?= $url ?>&pagina=<?= $anterior ?>" tabindex="-1"><i class="fas fa-arrow-left"></i> Anterior</a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a class="page-link produtos-paginas" href="/admin/produto?pagina=<?= $anterior ?>" tabindex="-1"><i class="fas fa-arrow-left"></i> Anterior</a></li>
                                    <?php endif; ?>

                                <?php endif ?>

                                <?php

                                if ($pagina > 4) {
                                    $i = $pagina - 5;
                                } else if ($pagina > 2) {
                                    $i = $pagina - 3;
                                } else {
                                    $i = $pagina - 1;
                                }

                                if ($totalDeLinks - $i > 8) {
                                    $total = $i + 8;
                                } else {
                                    $total = $totalDeLinks;
                                    $i = $total;
                                    for ($k = 0; $k < 8; $k++) {
                                        if ($i > 0) {
                                            $i--;
                                        }
                                    }
                                }

                                for ($i = $i; $i < $total; $i++) { ?>

                                    <?php if (isset($_GET) && !empty($_GET) && ((isset($_GET['Pesquisa']) && !empty($_GET['Pesquisa'])) || (isset($_GET['Categoria']) && !empty($_GET['Categoria'])))) :
                                        $url = unset_uri_var('pagina', basename($_SERVER['REQUEST_URI']));
                                    ?>
                                        <li class="page-item <?php if (($i + 1) == $pagina) : ?> produtos-paginas-clicado <?php endif ?>"><a class="page-link produtos-paginas <?php if (($i + 1) == $pagina) : ?> produtos-paginas-clicado <?php endif ?>" href="<?= $url ?>&pagina=<?= $i + 1 ?>"><?= $i + 1 ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item <?php if (($i + 1) == $pagina) : ?> produtos-paginas-clicado <?php endif ?>"><a class="page-link produtos-paginas <?php if (($i + 1) == $pagina) : ?> produtos-paginas-clicado <?php endif ?>" href="/admin/produto?pagina=<?= $i + 1 ?>"><?= $i + 1 ?></a></li>
                                    <?php endif; ?>

                                <?php } ?>

                                <?php if ($posterior <= $totalDeLinks) : ?>


                                    <?php if (isset($_GET) && !empty($_GET) && ((isset($_GET['Pesquisa']) && !empty($_GET['Pesquisa'])) || (isset($_GET['Categoria']) && !empty($_GET['Categoria'])))) :
                                        $url = unset_uri_var('pagina', basename($_SERVER['REQUEST_URI']));
                                    ?>
                                        <li class="page-item"><a class="page-link" href="<?= $url ?>&pagina=<?= $posterior ?>" tabindex="-1">Próxima <i class="fas fa-arrow-right"></i></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a class="page-link" href="/admin/produto?pagina=<?= $posterior ?>" tabindex="-1">Próxima <i class="fas fa-arrow-right"></i></a></li>
                                    <?php endif; ?>

                                <?php endif ?>

                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!--criar novo-->
<div class="modal" id="new" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionando novo produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="/admin/produto/create" method="POST" enctype="multipart/form-data">
                    <div class="form-group formulario-produto-admin">

                        <h5>Insira o nome do produto</h5>
                        <input type="text" name="item_name" class="form-control" placeholder="Nome do produto">

                        <h5>Insira o preço do produto(R$)</h5>
                        <input type="text" name="item_price" class="form-control" placeholder="Preço do produto">

                        <h5>Insira a quantidade em estoque</h5>
                        <input type="text" name="item_stock" class="form-control" placeholder="Quantidade em estoque">

                        <h5>Insira a descrição do produto</h5>
                        <textarea class="form-control" name="item_description" aria-label="With textarea"></textarea>

                        <h5>Insira a categoria</h5>
                        <select class="form-control" name="item_category" id="exampleFormControlSelect1">
                            <?php
                            foreach ($categorias as $categoria) : ?>
                                <option value="<?= $categoria->id; ?>">
                                    <?= $categoria->name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <h5>Foto</h5>
                        <input class="form-control" type="file" name="item_image">
                    </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button class="btn btn-success">Criar novo</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php require('app/views/partials/footer.admin.php') ?>
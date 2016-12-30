<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bugginho-Sena</title>

    <!-- Bootstrap -->
    <link href="Content/bootstrap.min.css" rel="stylesheet" />
    <link href="Content/style.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="page-header">
        <h1>Bugginho-Sena <small>Aposte de olhos fechados</small></h1>
    </div>
        <div class="panel panel-primary">
            <div class="panel-heading"><h2>Escolha o jogo que deseja sortear</h2></div>
            <div id="principal" class="panel-body">
                    <select id="jogosLoteria" name="jogosLoteria" class="form-control"
                            data-bind="options: Jogos,
                            value: selectedJogo,
                            optionsValue: 'id',
                            optionsText: 'nome'">
                    </select>
                    <label for="dezena">Informe o número de dezenas</label>

                <select id="dezenas" name="dezenas" class="form-control"
                        data-bind="options: Dezenas,
                            value: selectedDezena">
                </select>
                    <label for="dezena">Informe o número de apostas</label>
                    <input class="form-control" type="number" name="aposta" data-bind="value:totalAposta" min="1"/><br />
                <div class="well well-sm"><p data-bind="text: precoDezena()"></p>  </div>
                    <input class="form-control" type="submit" id="submeterAposta" name="submeterAposta" value="Apostar" /><br>
                <div id="testando"></div>
                <table id="jogosRealizados" class="table">
                    <thead>
                    <tr>
                        <th>Jogo</th>
                        <th>Horário</th>
                        <th>Dezenas</th>
                        <th>Valor</th>
                        <th>Apostas</th>
                        <th>Remover</th>
                    </tr>
                    </thead>
                    <tbody data-bind="foreach: jsonApostas">
                    <tr>
                        <td data-bind="text: NomeJogo"></td>
                        <td data-bind="text: DataAposta"></td>
                        <td data-bind="text: DezenasApostadas"></td>
                        <td data-bind="text: ValorAposta"></td>
                        <td><button type = "button" class = "btn btn-primary"
                                    data-bind="value:$parent.selectedAposta(), click:$parent.Visualizar">Ver aposta</button</td>
                        <td><button type = "button" data-bind="value:$parent.selectedAposta(), click:$parent.Excluir" class = "btn btn-danger">X</button></td>
                    </tr>
                    <tr id="sorteios" data-bind="text: NumerosSorteados" style="display:none;">
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="Scripts/jquery-1.9.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Scripts/bootstrap.min.js"></script>
    <script src='bower_components/knockout/dist/knockout.js'></script>
    <script src="Scripts/Loto.js"></script>
</body>
</html>


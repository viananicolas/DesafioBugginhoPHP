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
    <?php include 'Model/GameInfo.php'; $dadosJogos=lerJogos(); ?>
    <script type="text/javascript">
        var data = <?php echo $dadosJogos ?>;
        function JogosViewModel(){
            var self=this;
            self.Jogos=ko.observableArray(data);
            self.precoJogo=ko.observable(0.0);
            self.totalAposta=ko.observable(1);
            self.Dezenas=ko.observableArray();
            self.selectedJogo=ko.observable("");
            self.nomeJogo=ko.observable("");
            self.selectedAposta=ko.observable();
            self.selectedDezena=ko.observable(6);
            self.tempPreco=ko.observable(3.50);
            self.selecionadoJogo = ko.computed(function () {
                for (var i = 0; i < self.Jogos().length; i++) {
                    var dado = self.Jogos()[i];
                    if (dado.id === self.selectedJogo()) {
                        self.nomeJogo(dado.nome);
                        return dado;
                    }
                }
                return null;
            }, self);
            self.Dezenas=ko.computed(function(){
                if(self.selecionadoJogo()!=null){
                    var dado = [];
                    for(var x=0; x<self.selecionadoJogo().precos.length;){
                    for(var i=self.selecionadoJogo().min; i<=self.selecionadoJogo().max;i++){
                        dado[x]=i;
                        x++;
                        }
                    }
                    return dado;
                }
            },self);
            self.precoDezena = ko.computed(function () {
                var dez=self.selectedDezena();
                $("#dezenas").change(buscaPreco(dez)).trigger("change");
                function buscaPreco (dezena) {
                    $("dezenas").ready(function(){
                        for (var i = 0; i < self.Dezenas().length; i++) {
                            if (dezena === self.Dezenas()[i]) {
                                self.tempPreco =ko.observable(self.selecionadoJogo().precos[i]*self.totalAposta());
                                break;
                            }
                        }
                    }).trigger("change");
                }
                return "R$" +  (self.tempPreco()).toFixed(2);
            },self).extend({ notify: 'always' });
            self.Aposta={
                Id:ko.observable(""),
                NomeJogo:ko.observable(self.nomeJogo),
                TotalAposta:ko.observable(self.totalAposta),
                DezenasApostadas:ko.observable(self.selectedDezena),
                DataAposta:ko.observable(),
                NumerosSorteados:ko.observableArray([,]),
                ValorAposta:ko.observable(self.precoDezena)
            }
            self.jsonApostas=ko.observableArray();
            $.getJSON( "Model/aposta.json", function(json) {
                self.jsonApostas(json);
            });

            self.Visualizar=function (gf) {
                $( "#testando" ).empty();
                gf.NumerosSorteados.forEach(function (po) {
                    $("#testando").append("<div><h2 class='bg-info text-center sorteios'>"+po+"</h2></div>");
                    console.log(po);
                });
                console.log(gf.NumerosSorteados);
            };
            self.Excluir=function (gf) {
                self.Indice=self.jsonApostas.indexOf(gf);
                console.log(self.Indice);
                self.jsonApostas.remove(gf);
                var dado = ko.toJS({"Aposta":self.Indice});
                console.log(gf.Id);
                $.ajax({
                    url:"Model/ExcluirAposta.php",
                    type:'post',
                    data:dado,
                    success:function(result){
                        console.log(result);
                    }
                });
            };
            function getNewData(){
                $.getJSON( "Model/aposta.json", function(json) {
                    self.jsonApostas(json);
                });
            }

            $("#submeterAposta").click(function(){
                var dado = ko.toJS({"Aposta":self.Aposta});
                $.ajax({
                    url:"Model/GerarAposta.php",
                    type:'post',
                    data:dado,
                    success:function(result){
                        setTimeout(getNewData,900);
                    }
                });

            });
        }

        $(document).ready(function () {
            ko.applyBindings(new JogosViewModel());
        });
    </script>
</body>
</html>


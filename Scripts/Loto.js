/**
 * Created by nicol on 30/12/2016.
 */
function JogosViewModel(data){
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
    };
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
            success:function(){
                setTimeout(getNewData,900);
            }
        });

    });
}
var data;
$.ajaxSetup({
    async: false
});
$.getJSON("Model/jogos.json", init);
function init(result) {
    data = result;
}
$.ajaxSetup({
    async: true
});
$(document).ready(function () {
    ko.applyBindings(new JogosViewModel(data));
});
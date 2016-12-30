<?php

class Aposta
{
    var $Id;
    var $NomeJogo;
    var $TotalAposta;
    var $DezenasApostadas;
    var $DataAposta;
    var $NumerosSorteados;
    var $ValorAposta;

    function set_Id($new_Id) {
        $this->Id = $new_Id;
    }

    function set_NomeJogo($new_NomeJogo) {
        $this->NomeJogo = $new_NomeJogo;
    }

    function set_TotalAposta($new_TotalAposta) {
        $this->TotalAposta = $new_TotalAposta;
    }

    function set_DezenasApostadas($new_DezenasApostadas) {
        $this->DezenasApostadas = $new_DezenasApostadas;
    }

    function set_DataAposta($new_DataAposta) {
        $this->DataAposta = $new_DataAposta;
    }

    function set_NumerosSorteados($new_NumerosSorteados) {
        $this->NumerosSorteados = $new_NumerosSorteados;
    }

    function set_ValorAposta($new_ValorAposta) {
        $this->ValorAposta = $new_ValorAposta;
    }

    function get_Id() {
        return $this->Id;
    }

    function get_NomeJogo() {
        return $this->NomeJogo;
    }

    function get_TotalAposta() {
        return $this->TotalAposta;
    }

    function get_DezenasApostadas() {
        return $this->DezenasApostadas;
    }

    function get_DataAposta() {
        return $this->DataAposta;
    }

    function get_NumerosSorteados() {
        return $this->NumerosSorteados;
    }

    function get_ValorAposta() {
        return $this->ValorAposta;
    }
}
/*            self.Aposta={
                Id:ko.observable(""),
                IdJogo:ko.observable(self.selectedJogo),
                TotalAposta:ko.observable(self.totalAposta),
                DezenasApostadas:ko.observable(self.selectedDezena),
                DataAposta:ko.observable(new Date()),
                NumerosSorteados:ko.observableArray([,]);
                ValorAposta:ko.observable(self.precoDezena)
            }*/
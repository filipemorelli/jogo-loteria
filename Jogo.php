<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Jogo
 *
 * @author filipe
 */
class Jogo {

    private $qtdeDezenas;
    private $resultado;
    private $totalJogos;
    private $jogos;

    function getQtdeDezenas() {
        return $this->qtdeDezenas;
    }

    function getResultado() {
        return $this->resultado;
    }

    function getTotalJogos() {
        return $this->totalJogos;
    }

    function getJogos() {
        return $this->jogos;
    }

    function setQtdeDezenas($qtdeDezenas) {
        $this->validaQtdeDezenas($qtdeDezenas);
        $this->qtdeDezenas = $qtdeDezenas;
    }

    function setResultado($resultado) {
        $this->resultado = $resultado;
    }

    function setTotalJogos($TotalJogos) {
        $this->totalJogos = $TotalJogos;
    }

    function setJogos($jogos) {
        $this->jogos = $jogos;
    }

    public function __construct($qtdeDezenas, $totalJogos) {
        $this->validaQtdeDezenas($qtdeDezenas);
        $this->qtdeDezenas = $qtdeDezenas;
        $this->totalJogos  = $totalJogos;
    }

    private function validaQtdeDezenas($qtdeDezenas) {
        if ($qtdeDezenas < 6 || $qtdeDezenas > 10) {
            throw new Exception("Quantidade de dezenas deve estar entre 6 e 10.");
        }
    }

    private function geraJogoUnico($qtdeDezenas) {
        $numerosParaSortear = [];
        $dezenasSorteadas   = [];
        for ($i = 1; $i <= 60; $i++) {
            $numerosParaSortear[] = $i;
        }

        for ($i = 1; $i <= $qtdeDezenas; $i++) {
            $indiceSorteado     = rand(1, 60 - $i);
            $dezenasSorteadas[] = array_splice($numerosParaSortear, $indiceSorteado, 1)[0];
        }
        $dezenasSorteadas = array_values($dezenasSorteadas);
        sort($dezenasSorteadas);
        return $dezenasSorteadas;
    }

    public function geraJogos() {
        $jogos = [];
        for ($i = 0; $i < $this->totalJogos; $i++) {
            $jogos[] = $this->geraJogoUnico($this->qtdeDezenas);
        }
        $this->jogos = $jogos;
    }

    public function sorteioDezenas() {
        $this->resultado = $this->geraJogoUnico(6);
    }

    public function cofereJogos() {
        echo '<h1>Resultado dos jogos</h1>';

        echo '<table><tr>';
        foreach ($this->resultado as $key => $dezenasSorteadas) {
            echo "<td>{$dezenasSorteadas}</td>";
        }
        echo '</tr></table><br/>';

        echo '<table>';
        foreach ($this->jogos as $key => $jogo) {
            echo '<tr>';

            foreach ($jogo as $k => $dezena) {
                echo '<td>';
                if (in_array($dezena, $this->resultado)) {
                    echo "<b>{$dezena}</b>";
                }
                else {
                    echo $dezena;
                }
                echo '</td>';
            }

            echo '</tr>';
        }
        echo '</table>';
    }

}

$j = new Jogo(6, 10);
$j->geraJogos();
$j->sorteioDezenas();
$j->cofereJogos();

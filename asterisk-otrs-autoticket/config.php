<?php

/*
 * Copyright (C) 2017 guilherme.nogueira
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// ENDERECO DO SERVIDOR DO OTRS
$OTRS_URL = "http://192.168.0.9/otrs/";

// ENDERECO DO WEBSERVICE DE CRIACAO DE CHAMADOS
$OTRS_TICKET_WS_URL = "tickets-ws/";

// USUARIO DO WEBSERVICE DE CRIACAO DE CHAMADOS
$OTRS_TICKET_WS_USER = "diatech.integracao.ticket";

// SENHA DO WEBSERVICE DE CRIACAO DE CHAMADOS
$OTRS_TICKET_WS_PASSWORD = "c0nc3@diatech-$#02";

// ENDERECO DO SERVIDOR DO BANCO DE DADOS DO OTRS
$OTRS_DB_HOST = 'localhost';

// USUARIO DO BANCO DE DADOS DO OTRS
$OTRS_DB_USER = 'postgres';

// SENHA DO BANCO DE DADOS DO OTRS
$OTRS_DB_PASS = '';

// NOME DO BANCO DE DADOS DO OTRS
$OTRS_DB_NAME = 'otrs';

// ID PADRAO DE VALIDADE DO OTRS
$OTRS_VALID_ID = "1";

// CLIENTE PADRAO DE NOVOS CHAMADOS
$OTRS_DEFAULT_CUSTOMER = "0000";

// FILA PADRAO DE NOVOS CHAMADOS
$OTRS_DEFAULT_QUEUE = "Suporte - N1";

// ESTADO PADRAO DE NOVOS CHAMADOS
$OTRS_DEFAULT_STATE_NEW = "new";

// CLASSIFICACAO PADRAO DE NOVOS CHAMADOS
$OTRS_DEFAULT_TYPE = "Unclassified";

// PRIORIDADE PADRAO DE NOVOS CHAMADOS
$OTRS_DEFAULT_PRIORITY = "3 normal";

// DESTINO DAS CHAMADAS APOS CRIACAO DO CHAMADO
$ASTERISK_DEFAULT_DESTINATION = "ext-queues,3001,1";

// FAMILIA DE ARMAZENAMENTO DE LINKS DE TICKET DO OTRS NO ASTDB
$ASTERISK_DEFAULT_DB_FAMILY = "OTRS";
?>
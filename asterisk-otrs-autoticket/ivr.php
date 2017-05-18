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

require_once('lib/phpagi.php');
require_once('config.php');
require_once('util.php');
require_once('function.php');
require_once('sounds.php');

$AGI = new AGI();

$customer = null;

verbose("Iniciando ciclo de abertura de chamado");

print_r($AGI->request);

verbose("Aguarde, estamos tentando localizá-lo pelo seu número de telefone");
playSound($TRYING_TO_IDENTIFY_BY_PHONENUMBER);

$customer_phone = $AGI->request['agi_callerid'];

$customer = getCustomerByPhonenumber($customer_phone);

if ($customer == null) {

    verbose("Desculpe, seu número de telefone não consta em nossa base de clientes.");
    playSound($CUSTOMER_NOT_IDENTIFIED_BY_PHONENUMBER);

    verbose("Por favor, digite seu código do cliente e pressione jogo da velha para continuar. Se você não possui, ou não sabe seu código de cliente, aguarde.");
    $customer_id = requestData($TYPE_YOUR_CODE);

    verbose("Aguarde, estamos tentando localizá-lo em nossa base de dados");
    playSound($TRYING_TO_IDENTIFY_BY_CODE);
    $customer = getCustomerById($customer_id);
} else {

    verbose("Vejo aqui que o número do qual você está falando consta em nossa base de clientes");
    playSound($CUSTOMER_IDENTIFIED_BY_PHONENUMBER);
}

if ($customer == null) {

    verbose("Cliente não identificado. Atribuindo cliente padrão");
    $customer = getCustomerById($OTRS_DEFAULT_CUSTOMER);
}

verbose("Criando chamado no OTRS");
$ticket = createTicket($customer);

sayTicketNumber:

verbose("O número do seu chamado é");
playSound($SAYING_TICKET_NUMBER);
$AGI->say_digits($ticket->TicketNumber);

verbose("Se deseja ouvir o número do chamado novamente, pressione 1. ou aguarde para ser atendido");
if (requestData($REPEAT_TICKET_NUMBER) == 1) {

    goto sayTicketNumber;
}

verbose("Aguarde, estamos transferindo sua ligação para um de nossos atendentes. Informamos que a partir deste momento sua chamada está sendo gravada.");
playSound($TRANSFERING_CUSTOMER);
transferCustomer($ASTERISK_DEFAULT_DESTINATION);

verbose("Finalizando ciclo de abertura de chamado");
exit();
?>
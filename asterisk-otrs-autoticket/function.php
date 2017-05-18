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

function createTicket($customer) {

    global $OTRS_TICKET_WS_USER;
    global $OTRS_TICKET_WS_PASSWORD;
    global $OTRS_DEFAULT_QUEUE;
    global $OTRS_DEFAULT_STATE_NEW;
    global $OTRS_DEFAULT_TYPE;
    global $OTRS_DEFAULT_PRIORITY;

    $ticket_data = array(
        "UserLogin" => $OTRS_TICKET_WS_USER,
        "Password" => $OTRS_TICKET_WS_PASSWORD,
        "Ticket" => array(
            "Title" => "Novo chamado via telefone de $customer_company_name",
            "Queue" => $OTRS_DEFAULT_QUEUE,
            "CustomerUser" => $customer['customer_user_id'],
            "State" => $OTRS_DEFAULT_STATE_NEW,
            "Type" => $OTRS_DEFAULT_TYPE,
            "Priority" => $OTRS_DEFAULT_PRIORITY
        ),
        "Article" => array(
            "Subject" => "Novo chamado via telefone",
            "Body" => "Chamado aberto por " . $customer['customer_company_name'] . " via telefone.",
            "ContentType" => "text/plain; charset=utf8"
        )
    );

    return putOtrsWsData($ticket_data);
}

function getCustomerByPhonenumber($customer_phone) {

    global $OTRS_VALID_ID;

    $GET_CUSTOMER_DATA_BY_PHONENUMBER_QUERY = "SELECT cu.id AS customer_user_id, 
        cc.name AS customer_company_name 
        FROM customer_user cu 
        INNER JOIN customer_company cc ON cu.customer_id = cc.customer_id 
        WHERE cu.valid = '$OTRS_VALID_ID' 
        AND (
            cu.phone = '$customer_phone' 
            OR cu.fax = '$customer_phone' 
            OR cu.mobile = '$customer_phone' 
        ) 
        LIMIT 1";

    return getOtrsDbData($GET_CUSTOMER_DATA_BY_PHONENUMBER_QUERY);
}

function getCustomerById($customer_id) {

    global $OTRS_VALID_ID;

    $GET_CUSTOMER_DATA_BY_ID_QUERY = "SELECT cu.id AS customer_user_id, 
        cc.name AS customer_company_name 
        FROM customer_user cu 
        INNER JOIN customer_company cc ON cu.customer_id = cc.customer_id 
        WHERE cu.valid_id = '$OTRS_VALID_ID' 
        AND cu.customer_id = '$customer_id' 
        LIMIT 1";

    return getOtrsDbData($GET_CUSTOMER_DATA_BY_ID_QUERY);
}

function insertTicketLinkOnDb($uniqueid, $ticket_id) {

    global $OTRS_URL;

    $link = $OTRS_URL . "index.pl?Action=AgentTicketZoom;TicketID=" . $ticket_id;

    putAsteriskDbData($uniqueid, $link);
}

?>
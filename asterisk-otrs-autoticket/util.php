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

function verbose($message) {

    global $AGI;

    $AGI->verbose($message);
}

function transferCustomer($destination) {

    global $AGI;

    $AGI->exec_goto($destination);
}

function playSound($sound) {

    global $AGI;

    $AGI->stream_file($sound);
}

function requestData($sound) {

    global $AGI;

    $data = $AGI->get_data($sound);
    return $data['result'];
}

function putAsteriskDbData($key, $value) {

    global $ASTERISK_DEFAULT_DB_FAMILY;
    global $AGI;

    $AGI->database_put($ASTERISK_DEFAULT_DB_FAMILY, $key, $value);
}

function getAsteriskDbData($key) {

    global $ASTERISK_DEFAULT_DB_FAMILY;
    global $AGI;

    $AGI->database_get($ASTERISK_DEFAULT_DB_FAMILY, $key);
}

function putOtrsWsData($ticket_data) {

    global $OTRS_URL;
    global $OTRS_TICKET_WS_URL;

    $genericWS = "nph-genericinterface.pl/Webservice/";
    $operation = "TicketCreate/";

    $curl = curl_init($OTRS_URL . $genericWS . $OTRS_TICKET_WS_URL . $operation);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 20);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($ticket_data));

    $curl_response = curl_exec($curl);

    curl_close($curl);

    return json_decode($curl_response);
}

function getOtrsDbData($sql) {

    global $OTRS_DB_HOST;
    global $OTRS_DB_USER;
    global $OTRS_DB_PASS;
    global $OTRS_DB_NAME;

    $connection = pg_connect("host = $OTRS_DB_HOST user = $OTRS_DB_USER password = $OTRS_DB_PASS dbname = $OTRS_DB_NAME");

    $result = pg_query($connection, $sql);

    pg_close($connection);

    $data = pg_fetch_assoc($result);

    if (sizeof($data) > 0) {
        return $data[0];
    } else {
        return null;
    }
}

?>
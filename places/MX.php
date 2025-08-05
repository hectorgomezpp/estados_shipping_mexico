<?php
/**
 * Listado Ciudades de México por Estado
 * @link       https://perfectpool.cl
 * @since      1.0.0
 * @package    wc-ciudades-y-estados-de-mexico
 * @subpackage wc-ciudades-y-estados-de-mexico/places
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

global $places;

$places['MX'] = array(
    'MX-AGU' => array(
        'Aguascalientes',
        'Asientos',
        'Calvillo',
        'El Llano',
        'Jesús María',
        'Pabellón de Arteaga',
        'Rincón de Romos',
        'San José de Gracia',
        'Tepezalá',
        'San Francisco de los Romo',
    ),
    'MX-BC' => array(
        'Mexicali',
        'Tijuana',
        'Ensenada',
        'Playas de Rosarito',
        'Tecate',
    ),
    // ...repite para cada estado MX-BCS, MX-CAM, etc...
);

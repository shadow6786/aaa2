<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
 function invierte_fecha_mysql($fecha)
 {
   $day= substr($fecha,0,2);
   $month= substr($fecha,3,2);
   $year= substr($fecha,6,4);
       //$hour = substr($fecha,11,5);
       //formato salida: 0000-00-00
     $datetime_format=$year."-".$month."-".$day;
   return $datetime_format;
 }
 function invierte_fecha_usuario($fecha)
 {
   $day= substr($fecha,8,2);
   $month= substr($fecha,5,2);
   $year= substr($fecha,0,4);
   //$hour = substr($fecha,11,5);
   //formato salida:  00-00-0000
   $datetime_format=$day."-".$month."-".$year;
   return $datetime_format;
 }
 function invierte_fecha_web($fecha)
 {
   $day= substr($fecha,8,2);
   $month= substr($fecha,5,2);
   $year= substr($fecha,0,4);
   
   $days = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
   $months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  // formato de salida: {díasemana} {día} de {mes} del {año}
  return $days[date('w')]." ".date('d')." de ".$months[date('n')-1]. " del ".$year;
 }

<?php

class Itbiavalia
{
    public $it14_guia;
    public $it14_dtvenc;
    public $it14_dtliber;
    public $it14_obs;
    public $it14_valoraval;
    public $it14_valorpaga;
    public $it14_valoravalter;
    public $it14_valoravalconstr;
    public $it14_id_usuario;
    public $it14_hora;
    public $it14_desc;

    /**
     * @param $it14_guia
     * @return Itbiavalia
     */
    public function __construct($it14_guia = null)
    {
        if(empty($it14_guia) === true) {
            return $this;
        }
        /**
         * @var $itbiAvalia cl_itbiavalia
         */
        $itbiAvalia = db_utils::getDao('itbiavalia');
        $itbiAvalia = current(db_utils::getCollectionByRecord($itbiAvalia->sql_record($itbiAvalia->sql_query($it14_guia))));
        $this->it14_guia = $itbiAvalia->it14_guia;
        $this->it14_dtvenc = $itbiAvalia->it14_dtvenc;
        $this->it14_dtliber = $itbiAvalia->it14_dtliber;
        $this->it14_obs = $itbiAvalia->it14_obs;
        $this->it14_valoraval = $itbiAvalia->it14_valoraval;
        $this->it14_valorpaga = $itbiAvalia->it14_valorpaga;
        $this->it14_valoravalter = $itbiAvalia->it14_valoravalter;
        $this->it14_valoravalconstr = $itbiAvalia->it14_valoravalconstr;
        $this->it14_id_usuario = $itbiAvalia->it14_id_usuario;
        $this->it14_hora = $itbiAvalia->it14_hora;
        $this->it14_desc = $itbiAvalia->it14_desc;

        return $this;
    }

}

<?php

class ValidaTipoPregao
{
    /**
     * Undocumented function
     *
     * @param integer $tipoPregao
     * @return integer
     */
    public function execute(int $tipoPregao): int
    {
        return $tipoPregao === 2 ? 6 : 3;
    }
}

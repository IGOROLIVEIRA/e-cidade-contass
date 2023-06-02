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
        if ($tipoPregao == 2) {
            return 6;
        }

        return 3;
    }
}
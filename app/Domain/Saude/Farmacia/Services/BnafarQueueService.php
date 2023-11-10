<?php

namespace App\Domain\Saude\Farmacia\Services;

use App\Domain\Core\Models\BatchJob;
use App\Domain\Core\Services\QueueService;
use App\Domain\Saude\Farmacia\Models\BnafarBatch;
use App\Jobs\Saude\Farmacia\ExportarBnafarJob;

class BnafarQueueService
{
    /**
     * @var QueueService[]
     */
    private $queueService = [];

    /**
     * @param int $tipo
     * @return void
     */
    public function newBatch($tipo)
    {
        $this->queueService[$tipo] = new QueueService(ExportarBnafarJob::class);
        $service = $this->queueService[$tipo];

        BnafarBatch::create(['fa75_batch' => $service->getBatch()->id, 'fa75_tipo' => $tipo]);
    }

    /**
     * @param int $tipo
     * @return QueueService
     */
    public function getQueueService($tipo)
    {
        return $this->queueService[$tipo];
    }

    /**
     * @return void
     */
    public function terminate()
    {
        foreach ($this->queueService as $queueService) {
            $this->markAsDone($queueService->getBatch());
            $queueService->cancel();
        }
    }

    /**
     * @param BatchJob $batchJob
     * @return void
     */
    public static function markAsDone(BatchJob $batchJob)
    {
        $batch = BnafarBatch::where('fa75_batch', $batchJob->id)->first();
        $batch->fa75_concluido = true;
        $batch->save();
    }

    /**
     * @param int $tipo
     * @return int
     */
    public static function getNumProcess($tipo)
    {
        $batch = BnafarBatch::where('fa75_tipo', $tipo)->where('fa75_concluido', false)->first();
        if (!$batch) {
            return 0;
        }

        return $batch->batch->queuedJobs()->count() ?: 1;
    }
}

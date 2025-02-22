<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use App\Models\Log;

class DatabaseLogger extends AbstractProcessingHandler
{
 public function __construct($level = Level::Debug, bool $bubble = true)
 {
  parent::__construct($level, $bubble);
 }

 protected function write(LogRecord $record): void
 {
  Log::create([
   'level'   => $record->level->getName(),
   'message' => $record->message,
   'context' => json_encode($record->context),
   'status' => false,
  ]);
 }
}

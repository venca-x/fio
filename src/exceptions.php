<?php

namespace h4kuna\Fio;

abstract class FioException extends \Exception {}

class TransactionExtendException extends FioException {}

class TransactionPropertyException extends FioException {}

class QueueLimitException extends FioException {}

class FileUplodException extends FioException {}

class ServiceUnavailableException extends FioException {}

// no catch
class InvalidArgumentException extends \InvalidArgumentException {}

class RuntimeException extends \RuntimeException {}
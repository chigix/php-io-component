<?php

namespace Chigi\Component\IO;

/**
 * Signals that an end of file or end of stream has been reached unexpectedly during input.<br>
 * This exception is mainly used by data input streams to signal end of stream.<br>
 * Note that many other input operations return a special value on end of stream rather than throwing an excption.
 *
 * @author Richard Lea <chigix@zoho.com>
 */
class EOFException extends IOException {
    
}

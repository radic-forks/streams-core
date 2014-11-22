<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Addon\FieldType\Contract\DateFieldTypeInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Parser;

/**
 * Class EntryDatesParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryDatesParser extends Parser
{

    /**
     * Return the dates attribute.
     *
     * @param StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $string = "[";

        $string .= "\n{$this->s(8)}'created_at',";
        $string .= "\n{$this->s(8)}'updated_at',";

        foreach ($stream->getAssignments() as $assignment) {

            $this->parseAssignment($assignment, $string);
        }

        $string .= "\n{$this->s(4)}]";

        return $string;
    }

    /**
     * Parse an assignment.
     *
     * @param AssignmentInterface $assignment
     * @param                     $string
     */
    protected function parseAssignment(AssignmentInterface $assignment, &$string)
    {
        if ($type = $assignment->getFieldType() and $type instanceof DateFieldTypeInterface) {

            $string .= "\n{$this->s(8)}'{$assignment->getFieldSlug()}',";
        }
    }
}
 
<?php

namespace Zidoc\CommonMark\Listener;

use Doctrine\Common\Inflector\Inflector;
use League\CommonMark\Block\Element\Heading;
use phootwork\collection\Set;
use Zidoc\CommonMark\Event\PostDocParseEvent;

/**
 * Class HeadingListener
 */
class HeadingListener
{
    /**
     * @param PostDocParseEvent $event
     */
    public function onPostDocParse(PostDocParseEvent $event): void
    {
        $document = $event->getDocument();

        $cache = new Set();
        foreach ($document->children() as $child) {
            if (!$child instanceof Heading) {
                continue;
            }

            $this->addAnchor($child, $cache);
        }
    }

    /**
     * @param Heading $heading
     * @param Set     $cache
     */
    private function addAnchor(Heading $heading, Set $cache): void
    {
        $attempts = 1;
        do {
            $anchor = $this->sluggify($heading->getStringContent());
            if ($attempts > 1) {
                $anchor .= $attempts - 1;
            }
            $attempts++;
        } while ($cache->contains($anchor));

        $cache->add($anchor);

        $heading->data['attributes'] = array_merge($heading->getData('attributes', []), [
            'id' => $anchor,
        ]);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function sluggify(string $text): string
    {
        return str_replace(' ', '-', str_replace('_', '-', Inflector::tableize($text)));
    }
}

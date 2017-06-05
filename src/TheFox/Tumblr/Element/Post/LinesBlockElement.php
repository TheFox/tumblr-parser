<?php

namespace TheFox\Tumblr\Element\Post;

class LinesBlockElement extends LineBlockElement
{
    public function render()
    {
        $html = '';
        $lines = $this->getContent();

        if ($lines && is_array($lines)) {
            $usersId = 0;
            $users = array();

            $alt = 'even';
            foreach ($lines as $lineId => $line) {
                #$line['name'] = 'your_tumblr_username';

                $alt = $alt == 'odd' ? 'even' : 'odd';
                $line['alt'] = $alt;

                $userNumber = 0;
                if (!isset($line['userNumber']) && isset($line['label']) && $line['label']) {
                    $labelLower = strtolower($line['label']);

                    $userNumber = array_search($labelLower, $users);
                    if ($userNumber === false) {
                        $userNumber = array_push($users, $labelLower);
                    }
                }


                $line['userNumber'] = $userNumber;

                $this->setContent($line);
                $this->setElementsValues();
                $html .= parent::render();
            }
        }

        // Reset original content.
        $this->setContent($lines);

        return $html;
    }
}

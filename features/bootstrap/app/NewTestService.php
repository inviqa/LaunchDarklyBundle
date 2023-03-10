<?php

namespace Inviqa\LaunchDarklyBundle\Tests;

class NewTestService implements TestService
{
    public function getContent()
    {
        return "<html><body>the new service content</body></html>";
    }
}

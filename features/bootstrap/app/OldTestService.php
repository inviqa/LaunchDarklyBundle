<?php

namespace Inviqa\LaunchDarklyBundle\Tests;

class OldTestService implements TestService
{
    public function getContent()
    {
        return "<html><body>the old service content</body></html>";
    }
}

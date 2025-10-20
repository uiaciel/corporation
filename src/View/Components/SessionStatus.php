<?php

namespace Uiaciel\Corporation\View\Components;

use Illuminate\View\Component;

class SessionStatus extends Component
{
    public function render()
    {
        return view('corporation::components.session-status');
    }
}

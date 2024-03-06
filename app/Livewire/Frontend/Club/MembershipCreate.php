<?php

namespace App\Livewire\Frontend\Club;

use App\Models\ClubRate;
use App\Models\CourseSubcategory;
use App\Models\RateCategory;
use App\Traits\HasLogin;
use App\Traits\HasPage;
use Livewire\Component;

class MembershipCreate extends Component
{
    use HasLogin, HasPage;

    protected $identifier = "mitgliedschaft";

    public $page;
    public $rateOption = null;
    public $rate = null;
    public $courses;
    public $selectedCourses = [];
    public $rateCategory;
    public $rate_categories;

    public $currentStep = 1;
    public $stepCount = 3;
    public $width = 0;

    public function mount()
    {
        $this->rateCategory = RateCategory::all();

        $this->courses = CourseSubcategory::where('is_club', true)
            ->with('courses')
            ->get()
            ->flatMap->courses;

        $this->width = 100 / $this->stepCount;
    }

    public function nextStep()
    {
        if ($this->stepCount === 1) return;
        $this->stepCount--;
        $this->width = 100 / $this->stepCount;
    }

    public function previousStep()
    {
        $this->stepCount++;
        $this->width = 100 / $this->stepCount;
    }

    public function updatedRateOption(ClubRate $value)
    {
        $this->rate = $value;
    }

    public function addCourseOption($course)
    {
        $this->selectedCourses[] = $course;
    }
}

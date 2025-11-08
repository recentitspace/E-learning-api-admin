<?php

namespace Modules\LMS\Repositories;

use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\Courses\OutcomesRepository;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuizQuestionRepository;
use Modules\LMS\Repositories\Skill\SkillRepository;
use Modules\LMS\Repositories\User\CompanyRepository;
use Modules\LMS\Repositories\User\UniversityRepository;

class SearchSuggestionRepository
{
    public function __construct(protected CourseRepository $course, protected OutcomesRepository $outcomes, protected QuizQuestionRepository $quiz, protected UniversityRepository $university, protected CompanyRepository $company, protected SkillRepository $skill) {}

    /**
     * searchSuggestion
     *
     * @param  mixed  $request
     */
    public function searchSuggestion($request)
    {
        switch ($request->search_type) {
            case 'requirement':
                $results = $this->course->requirementSearch($request);

                return $this->resultFormat($results);

            case 'outcomes':
                $results = $this->outcomes->outcomesSearch($request);

                return $this->resultFormat($results);
            case 'question':
            case 'answer':
                $results = $this->quiz->searchingSuggestion($request);

                return $this->resultFormat($results);

            case 'university':
                $results = $this->university->universitySearch($request);

                return $this->resultFormat($results);
            case 'company':
                $results = $this->company->companySearch($request);

                return $this->resultFormat($results);
            case 'skill':
                return $this->skill->skillSearch($request);
        }
    }

    /**
     *  resultFormat
     *
     * @param  object  $results
     */
    protected function resultFormat($results)
    {
        if (count($results) > 0) {
            $output = '<ul class="search-data dropdown-menu absolute left-0 top-full min-w-40 p-1.5 bg-white text-gray-500 dark:text-dark-text rounded-md border border-input-border shadow-md text-sm divide-y divide-gray-200 dark:divide-dark-border-three z-10">';
            foreach ($results as $result) {
                $output .= '<li class="py"><a href="#">' . (isset($result->title) ? $result->title : $result->name) . '</a></li>';
            }
            $output .= '</ul>';

            return $output;
        }
    }
}

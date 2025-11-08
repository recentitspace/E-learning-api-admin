<div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10" data-tab="courseCurriculum">
    <article>
        <h2 class="area-title xl:text-3xl mb-5"> {{ translate('Course Curriculum') }} </h2>
        <div class=" border border-border">
            <x-theme::course.curriculum-list :course="$course" sideBarShow="detail" :auth="$auth ?? false"
                :purchaseCheck=$purchaseCheck />
        </div>
    </article>
</div>

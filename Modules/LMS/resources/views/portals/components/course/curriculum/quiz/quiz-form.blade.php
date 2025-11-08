   <!-- Start Edit Quiz Modal -->
   <div id="editQuiz" tabindex="-1"
       class="fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
       <div class="p-4 w-full max-w-2xl max-h-full">
           <div class="relative bg-white dark:bg-dark-card-two rounded-lg dk-theme-card-square shadow">
               <button type="button" data-modal-hide="editQuiz"
                   class="absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center">
                   <i class="ri-close-fill text-gray-500 dark:text-dark-text text-xl leading-none"></i>
               </button>
               <div class="p-4 md:p-5">
                   <div class="pb-4 border-b border-gray-200 dark:border-dark-border">
                       <h6 class="leading-none text-lg font-semibold text-heading">{{ translate('Add Question') }}</h6>
                   </div>
                   <form action="{{ $action ?? '#' }}" class="flex flex-col gap-10 mt-6 form" method="POST">
                       @csrf
                       <input type="hidden" name="quiz_id" id="quizId">
                       <div class="max-h-[80vh] overflow-auto">
                           <div class="overflow-hidden">
                               <div class="relative">
                                   <label for="quiz-question"
                                       class="form-label">{{ translate('Question Title') }} <span class="text-danger">*</span></label>
                                   <textarea name="title" rows="1" id="searchInput" data-search-type="question"
                                       class="form-input search-suggestion"> </textarea>
                                   <div class="search-show"></div>
                                   <span class="text-danger error-text title_err"></span>
                               </div>
                               <div class="mt-4">
                                   <label for="quiz-grade" class="form-label">{{ translate('Quiz Mark') }} <span class="text-danger">*</span></label>
                                   <input type="number" name="mark" id="quiz-grade" class="form-input"></input>
                                   <span class="text-danger error-text mark_err"></span>
                               </div>
                               <div class="mt-4">
                                   <label class="form-label">{{ translate('Quiz Type') }} <span class="text-danger">*</span></label>
                                   <select class="singleSelect quiz-type-list" name="question_type" required>
                                       <option selected disabled>{{ translate('Select quiz Question type') }}</option>
                                       <option value="multiple-choice">{{ translate('Multiple choice') }}</option>
                                       <option value="single-choice">{{ translate('Single choice') }}</option>
                                       <option value="fill-in-blank">{{ translate('Fill in the blank') }}</option>
                                   </select>
                                   <span class="text-danger error-text question_type_err"></span>
                               </div>
                               <div class="answer-list-area">
                               </div>
                           </div>
                       </div>
                       <div class="flex-center">
                           <button type="submit"
                               class="btn b-solid btn-primary-solid w-1/2">{{ translate('Update Quiz') }}</button>
                       </div>
                   </form>
               </div>

           </div>
       </div>
   </div>
   <!-- End Edit Quiz Modal -->

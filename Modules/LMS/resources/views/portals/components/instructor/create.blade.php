 @php
     $userInfo = $instructor?->userable ?? null;
     $locale = $locale ?? app()->getLocale();
     $translations = $translations ?? [];
     $designationData = [];
     if (empty($translations) && $userInfo) {
         $translations = parse_translation($userInfo, $locale);
     }

     if ($userInfo?->designation) {
         $designationData = parse_translation($userInfo?->designation, $locale);
     }

     $translateRoute = 'instructor.translate';

     if (isOrganization()) {
         $translateRoute = 'organization.instructor.translate';
     }
 @endphp

 <form action="{{ $action ?? '#' }}" method="post" class="form" enctype="multipart/form-data">
     @csrf
     @if (isset($instructor) && !empty($instructor))
         @method('PUT')
     @endif
     @if (isOrganization())
         <input type="hidden" name="organization_id" value="{{ authCheck()->id }}">
     @endif
     <input type="hidden" name="locale" class="form-input" value="{{ $locale ?? '' }}">
     <div class="grid grid-cols-12 gap-x-4">
         <div class="col-span-full {{ is_active($translateRoute) !== 'active' ? 'lg:col-span-8' : '' }} card">
             <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                 <div class="col-span-full xl:col-auto leading-none">
                     <label for="name" class="form-label">
                         {{ translate('First Name') }}
                         <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                     </label>
                     <input type="text" id="name" name="first_name"
                         value="{{ $translations['first_name'] ?? ($userInfo?->first_name ?? '') }}"
                         placeholder="{{ translate('Enter First Name') }}" class="form-input">
                     <span class="text-danger error-text first_name_err"></span>
                 </div>
                 <div class="col-span-full xl:col-auto leading-none">
                     <label for="last_name" class="form-label">
                         {{ translate('Last Name') }}
                         <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                     </label>
                     <input type="text" id="last_name" name="last_name"
                         value="{{ $translations['last_name'] ?? ($userInfo?->last_name ?? '') }}"
                         placeholder="{{ translate('Enter Last Name') }}" class="form-input">
                     <span class="text-danger error-text last_name_err"></span>
                 </div>
                 @if (is_active($translateRoute) !== 'active')
                     <div class="col-span-full xl:col-auto leading-none">
                         <label for="phone-number" class="form-label">
                             {{ translate('Phone Number') }}
                             <span class="text-danger"
                                 title="{{ translate('This field is required') }}"><b>*</b></span>
                         </label>
                         <input type="text" id="phone-number" name="phone" value="{{ $userInfo?->phone ?? '' }}"
                             placeholder="{{ translate('Enter Phone Number') }}" class="form-input">
                         <span class="text-danger error-text phone_err"></span>
                     </div>
                 @endif
                 @if (is_active($translateRoute) !== 'active')
                     <div class="col-span-full xl:col-auto leading-none">
                         <label for="email" class="form-label">
                             {{ translate('Email') }}
                             <span class="text-danger"
                                 title="{{ translate('This field is required') }}"><b>*</b></span>
                         </label>
                         <input type="text" id="email" name="email"
                             placeholder="{{ translate('Enter Email') }}" class="form-input"
                             value="{{ $instructor?->email ?? '' }}">
                         <span class="text-danger error-text email_err"></span>
                     </div>
                 @endif
                 @if (!isset($instructor) && is_active($translateRoute) !== 'active')
                     <div class="col-span-full xl:col-auto leading-none">
                         <label for="password" class="form-label">
                             {{ translate('Password') }}
                             <span class="text-danger"
                                 title="{{ translate('This field is required') }}"><b>*</b></span>
                         </label>
                         <input type="password" id="password" name="password"
                             placeholder="{{ translate('Enter Password') }}" class="form-input">
                         <span class="text-danger error-text password_err"></span>
                     </div>
                     <div class="col-span-full xl:col-auto leading-none">
                         <label for="confirmation-password" class="form-label">
                             {{ translate('Confirm Password') }}
                             <span class="text-danger"
                                 title="{{ translate('This field is required') }}"><b>*</b></span>
                         </label>
                         <input type="password" id="confirmation-password" name="password_confirmation"
                             placeholder="{{ translate('Confirm Password') }}" class="form-input">
                     </div>

                     <div class="col-span-full xl:col-auto leading-none">
                         <label class="form-label">
                             {{ translate('Country') }}

                         </label>
                         <select class="country-list form-input px-5 py-4 rounded-10 country-state" name="country_id">
                             <option disabled selected>{{ translate('Select Country') }}</option>
                             @foreach (get_all_country(locale: $locale) as $country)
                                 @php
                                     $countryTranslations = parse_translation($country, $locale);
                                 @endphp
                                 <option value="{{ $country->id }}"
                                     {{ isset($instructor) && $userInfo?->country_id == $country->id ? 'selected' : '' }}>
                                     {{ $countryTranslations['name'] ?? $country->name }}</option>
                             @endforeach
                         </select>
                         <span class="text-danger error-text country_id_err"></span>
                     </div>
                     <div class="col-span-full xl:col-auto leading-none">
                         <label for="state" class="form-label">
                             {{ translate('State') }}

                         </label>
                         <select class="state-list form-input px-5 py-4 rounded-10 state-city" id="stateOption"
                             name="state_id">
                             <option disabled selected>{{ translate('Select State') }}</option>
                         </select>
                         <span class="text-danger error-text state_id_err"></span>
                     </div>
                     <div class="col-span-full xl:col-auto leading-none">
                         <label for="state" class="form-label">
                             {{ translate('City') }}

                         </label>
                         <select class="city-list form-input px-5 py-4 rounded-10" id="cityOption" name="city_id">
                             <option disabled selected>{{ translate('Select City') }}</option>
                         </select>
                         <span class="text-danger error-text city_id_err"></span>
                     </div>
                 @endif
                 <div class="col-span-full xl:col-auto leading-none">
                     <label class="form-label">
                         {{ translate('Designation') }}
                         <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                     </label>
                     <input type="text" name="designation"
                         value="{{ $designationData['title'] ?? ($userInfo?->designation?->title ?? '') }}"
                         placeholder="{{ translate('Enter Designation') }}" class="form-input">
                     <span class="text-danger error-text designation_err"></span>
                 </div>
                 <div class="col-span-full leading-none">
                     <label for="address" class="form-label">
                         {{ translate('Address') }}
                     </label>
                     <input type="text" id="address" name="address"
                         value="{{ $translations['address'] ?? ($userInfo?->address ?? '') }}"
                         placeholder="{{ translate('Enter Address') }}" class="form-input">
                     <span class="text-danger error-text address_err"></span>
                 </div>
                 <div class="col-span-full leading-none">
                     <label for="address" class="form-label">
                         {{ translate('About') }}
                     </label>
                     <textarea name="about" class="summernote">{!! clean($translations['about'] ?? ($userInfo?->about ?? '')) !!}</textarea>
                 </div>
             </div>
         </div>
         @if (is_active($translateRoute) !== 'active')
             <div class="col-span-full lg:col-span-4 card">
                 <div class="p-1.5">
                     @if (isset($instructor))
                         <div class="mb-3">
                             <h2 class="card-title">{{ translate('Change Password') }}</h2>
                         </div>
                         <div class="col-span-full xl:col-auto leading-none mb-4">
                             <label class="form-label">
                                 {{ translate('Password') }}
                                 <span class="text-danger"
                                     title="{{ translate('This field is required') }}"><b>*</b></span>
                             </label>
                             <input type="password" name="password" placeholder="{{ translate('Enter Password') }}"
                                 class="form-input">
                             <span class="text-danger error-text password_err"></span>
                         </div>
                         <div class="col-span-full xl:col-auto leading-none mb-4">
                             <label class="form-label">
                                 {{ translate('Confirm Password') }}
                                 <span class="text-danger"
                                     title="{{ translate('This field is required') }}"><b>*</b></span>
                             </label>
                             <input type="password" name="password_confirmation"
                                 placeholder="{{ translate('Confirm Password') }}" class="form-input">
                         </div>
                     @endif

                     <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                         {{ translate('Profile Image') }}({{ translate('200') }}x{{ translate('200') }})
                     </p>
                     <div>
                         <label for="profile"
                             class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                             <input type="file" hidden name="image" id="profile"
                                 class="dropzone dropzone-image img-src peer/file">
                             <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                 <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                     class="size-8 lg:size-auto">
                                 <div class="text-gray-500 dark:text-dark-text mt-2">{{ translate('Choose file') }}
                                 </div>
                             </span>
                             <span class="text-danger error-text image_err"></span>
                         </label>
                         <div class="preview-zone dropzone-preview">
                             <div class="box box-solid">
                                 <div class="box-body flex items-center gap-2 flex-wrap">
                                     @if (isset($instructor) &&
                                             fileExists($folder = 'lms/instructors', $fileName = $userInfo?->profile_img) == true &&
                                             $userInfo?->profile_img !== '')
                                         <div class="img-thumb-wrapper"> <button class="remove">
                                                 <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                             <img class="img-thumb" width="100"
                                                 src="{{ asset('storage/lms/instructors/' . $userInfo?->profile_img) }}" />
                                         </div>
                                     @endif
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="mt-7">
                         <label class="form-label"> {{ translate('Cover Image') }} </label>
                         <label
                             class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                             <input type="file" hidden name="profile_cover"
                                 class="dropzone dropzone-image img-src peer/file">
                             <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                                 <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                                     class="size-8 lg:size-auto">
                                 <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }}
                                 </div>
                             </span>
                         </label>
                         <div class="preview-zone dropzone-preview">
                             <div class="box box-solid">
                                 <div class="box-body flex items-center gap-2 flex-wrap">

                                     @if (isset($instructor) &&
                                             fileExists('lms/instructors', $fileName = $userInfo?->cover_photo) == true &&
                                             $userInfo?->cover_photo !== '')
                                         <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                                 <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                             <img class="img-thumb" width="100"
                                                 src="{{ asset('storage/lms/instructors/' . $userInfo?->cover_photo) }}" />
                                         </div>
                                     @endif
                                 </div>
                             </div>
                         </div>
                         <span class="text-danger error-text profile_cover_err"></span>
                     </div>
                 </div>
             </div>
         @endif
         <div class="col-span-full card flex justify-end">
             <button type="submit" class="btn b-solid btn-primary-solid w-max dk-theme-card-square">
                 {{ isset($instructor) ? translate('Update') : translate('Save') }}
             </button>
         </div>
     </div>
 </form>

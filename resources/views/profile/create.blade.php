@extends('layouts.app')

@section('title', "Create a Profile")
@section('subtitle', 'Build a new profile ready for sharing')

@section('content')
    <div class="form-wrapper container" v-cloak>
        <div class="columns">
            <div class="column is-8 is-offset-2">
                <!-- Name -->
                <p class="is-size-5-desktop is-size-6-touch has-text-weight-light m-t-15 m-b-5">A profile identifier allows you to tell <b class="has-text-weight-normal">profiles apart</b>.</p>
                <div class="field">
                    <div class="control has-icons-left has-icons-right" :class="{'is-loading': nameLoading}">
                        <input name="name" v-model="name" data-vv-as="identifier" type="text" class="input" :class="{'is-danger': (errors.has('name') || !nameAvailable) &amp;&amp; !nameLoading, 'is-success': fields.name &amp;&amp; fields.name.valid &amp;&amp; nameAvailable &amp;&amp; !nameLoading}" placeholder="Profile Identifer" v-validate="'required|alpha_dash|max:16'" value="{{ old('name') }}" required>
                        <span class="icon is-small is-left">
                            <i class="fa fa-key"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fa" :class="{'fa-warning': (errors.has('name') || !nameAvailable) &amp;&amp; !nameLoading, 'fa-check': fields.name &amp;&amp; fields.name.valid &amp;&amp; !nameLoading}"></i>
                        </span>
                    </div>
                    <p class="help is-danger" :show="errors.has('name')">@{{ errors.first('name') }}</p>
                    <p class="help is-danger" v-show="!errors.has('name') &amp;&amp; !nameAvailable &amp;&amp; !nameLoading">You've already used that name.</p>
                </div>
                <!-- End Name -->

                <!-- Link -->
                <p class="is-size-5-desktop is-size-6-touch has-text-weight-light m-t-15 m-b-5">Make you <b class="has-text-weight-normal">link</b> special! This is what people type into the internet.</p>
                <div class="field has-addons">
                    <div class="control">
                        <a class="button is-static">
                            <span class="icon is-small"><i class="fa fa-chain"></i></span><span>{{ env('APP_URL') . '/@' }}</span>
                        </a>
                    </div>
                    <div class="control has-icons-right" :class="{'is-loading': linkLoading}">
                        <input name="link" v-model="link" type="text" class="input" :class="{'is-danger': (errors.has('link') || !linkAvailable) &amp;&amp; !linkLoading, 'is-success': fields.link &amp;&amp; fields.link.valid &amp;&amp; linkAvailable &amp;&amp; !linkLoading}" placeholder="Link" v-validate="'required|alpha_dash|min:3|max:32'" value="{{ old('link') }}" required>
                        <span class="icon is-small is-right">
                            <i class="fa" :class="{'fa-warning': (errors.has('link') || !linkAvailable) &amp;&amp; !linkLoading, 'fa-check': fields.link &amp;&amp; fields.link.valid &amp;&amp; !linkLoading}"></i>
                        </span>
                    </div>
                </div>
                <p class="help is-danger" :show="errors.has('link')" style="margin-top: -0.5rem">@{{ errors.first('link') }}</p>
                <p class="help is-danger" v-show="!errors.has('link') &amp;&amp; !linkAvailable &amp;&amp; !linkLoading">That link is already in use.</p>
                <!-- End Link -->

                <!-- Display Name -->
                <p class="is-size-5-desktop is-size-6-touch has-text-weight-light m-t-15 m-b-5">This is the <b class="has-text-weight-normal">name</b> shown on your profile.</p>
                <div class="field">
                    <div class="control has-icons-left has-icons-right">
                        <input name="displayName" data-vv-as="display name" v-model="displayName" type="text" class="input" :class="{'is-danger': errors.has('displayName'), 'is-success': fields.displayName &amp;&amp; fields.displayName.valid}" placeholder="Display Name" v-validate="'required|min:2|max:50'" value="{{ old('displayName') }}" required>
                        <span class="icon is-small is-left">
                            <i class="fa fa-address-book-o"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fa" :class="{'fa-warning': errors.has('displayName'), 'fa-check': fields.displayName &amp;&amp; fields.displayName.valid}"></i>
                        </span>
                    </div>
                    <p class="help is-danger" :show="errors.has('displayName')">@{{ errors.first('displayName') }}</p>
                </div>
                <!-- End Display Name -->

                <!-- Motto -->
                <p class="is-size-5-desktop is-size-6-touch has-text-weight-light m-t-15 m-b-5">Want to show a little <b class="has-text-weight-normal">message</b> below your name?</p>
                <div class="field">
                    <div class="control">
                        <textarea name="motto" rows="2" v-model="motto" class="textarea" :class="{'is-danger': errors.has('motto'), 'is-success': fields.motto &amp;&amp; fields.motto.valid}" placeholder="Motto" v-validate="'min:1|max:100'">{{ old('motto') }}</textarea>
                    </div>
                </div>
                <!-- End Motto -->

                <!-- Date of Birth -->
                <p class="is-size-5-desktop is-size-6-touch has-text-weight-light m-t-15 m-b-5">Your <b class="has-text-weight-normal">date of birth</b> can be shown too.</p>
                <div class="field has-addons">
                    <div class="control">
                        <div class="select">
                            <select name="dob_day">
                                <option selected>Day</option>
                                @for ($i=1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ $i === old('dob_day') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="control">
                        <div class="select">
                            <select name="dob_month">
                                <option selected>Month</option>
                                @for ($i=1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i === old('dob_month') ? 'selected' : '' }}>{{ date('F', strtotime("1970-$i-1")) }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="control">
                        <div class="select">
                            <select name="dob_year">
                                <option selected>Year</option>
                                @for ($i=date('Y'); $i >= date('Y') - 128; $i--)
                                    <option value="{{ $i }}" {{ $i === old('dob_year') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <!-- End Date of Birth -->

                <!-- Country -->
                <p class="is-size-5-desktop is-size-6-touch has-text-weight-light m-t-15 m-b-5">Show off your <b class="has-text-weight-normal">patriotism</b>!</p>
                <div class="field">
                    <div class="control has-icons-left">
                        <span class="select">
                            <select name="country">
                                <option selected>Country</option>
                                <?php $countries = array("AF" => "Afghanistan","AL" => "Albania","DZ" => "Algeria","AS" => "American Samoa","AD" => "Andorra","AO" => "Angola","AI" => "Anguilla","AQ" => "Antarctica","AG" => "Antigua and Barbuda","AR" => "Argentina","AM" => "Armenia","AW" => "Aruba","AU" => "Australia","AT" => "Austria","AZ" => "Azerbaijan","BS" => "Bahamas","BH" => "Bahrain","BD" => "Bangladesh","BB" => "Barbados","BY" => "Belarus","BE" => "Belgium","BZ" => "Belize","BJ" => "Benin","BM" => "Bermuda","BT" => "Bhutan","BO" => "Bolivia","BA" => "Bosnia and Herzegovina","BW" => "Botswana","BV" => "Bouvet Island","BR" => "Brazil","BQ" => "British Antarctic Territory","IO" => "British Indian Ocean Territory","VG" => "British Virgin Islands","BN" => "Brunei","BG" => "Bulgaria","BF" => "Burkina Faso","BI" => "Burundi","KH" => "Cambodia","CM" => "Cameroon","CA" => "Canada","CT" => "Canton and Enderbury Islands","CV" => "Cape Verde","KY" => "Cayman Islands","CF" => "Central African Republic","TD" => "Chad","CL" => "Chile","CN" => "China","CX" => "Christmas Island","CC" => "Cocos [Keeling] Islands","CO" => "Colombia","KM" => "Comoros","CG" => "Congo - Brazzaville","CD" => "Congo - Kinshasa","CK" => "Cook Islands","CR" => "Costa Rica","HR" => "Croatia","CU" => "Cuba","CY" => "Cyprus","CZ" => "Czech Republic","CI" => "Côte d’Ivoire","DK" => "Denmark","DJ" => "Djibouti","DM" => "Dominica","DO" => "Dominican Republic","NQ" => "Dronning Maud Land","DD" => "East Germany","EC" => "Ecuador","EG" => "Egypt","SV" => "El Salvador","GQ" => "Equatorial Guinea","ER" => "Eritrea","EE" => "Estonia","ET" => "Ethiopia","FK" => "Falkland Islands","FO" => "Faroe Islands","FJ" => "Fiji","FI" => "Finland","FR" => "France","GF" => "French Guiana","PF" => "French Polynesia","TF" => "French Southern Territories","FQ" => "French Southern and Antarctic Territories","GA" => "Gabon","GM" => "Gambia","GE" => "Georgia","DE" => "Germany","GH" => "Ghana","GI" => "Gibraltar","GR" => "Greece","GL" => "Greenland","GD" => "Grenada","GP" => "Guadeloupe","GU" => "Guam","GT" => "Guatemala","GG" => "Guernsey","GN" => "Guinea","GW" => "Guinea-Bissau","GY" => "Guyana","HT" => "Haiti","HM" => "Heard Island and McDonald Islands","HN" => "Honduras","HK" => "Hong Kong SAR China","HU" => "Hungary","IS" => "Iceland","IN" => "India","ID" => "Indonesia","IR" => "Iran","IQ" => "Iraq","IE" => "Ireland","IM" => "Isle of Man","IL" => "Israel","IT" => "Italy","JM" => "Jamaica","JP" => "Japan","JE" => "Jersey","JT" => "Johnston Island","JO" => "Jordan","KZ" => "Kazakhstan","KE" => "Kenya","KI" => "Kiribati","KW" => "Kuwait","KG" => "Kyrgyzstan","LA" => "Laos","LV" => "Latvia","LB" => "Lebanon","LS" => "Lesotho","LR" => "Liberia","LY" => "Libya","LI" => "Liechtenstein","LT" => "Lithuania","LU" => "Luxembourg","MO" => "Macau SAR China","MK" => "Macedonia","MG" => "Madagascar","MW" => "Malawi","MY" => "Malaysia","MV" => "Maldives","ML" => "Mali","MT" => "Malta","MH" => "Marshall Islands","MQ" => "Martinique","MR" => "Mauritania","MU" => "Mauritius","YT" => "Mayotte","FX" => "Metropolitan France","MX" => "Mexico","FM" => "Micronesia","MI" => "Midway Islands","MD" => "Moldova","MC" => "Monaco","MN" => "Mongolia","ME" => "Montenegro","MS" => "Montserrat","MA" => "Morocco","MZ" => "Mozambique","MM" => "Myanmar [Burma]","NA" => "Namibia","NR" => "Nauru","NP" => "Nepal","NL" => "Netherlands","AN" => "Netherlands Antilles","NT" => "Neutral Zone","NC" => "New Caledonia","NZ" => "New Zealand","NI" => "Nicaragua","NE" => "Niger","NG" => "Nigeria","NU" => "Niue","NF" => "Norfolk Island","KP" => "North Korea","VD" => "North Vietnam","MP" => "Northern Mariana Islands","NO" => "Norway","OM" => "Oman","PC" => "Pacific Islands Trust Territory","PK" => "Pakistan","PW" => "Palau","PS" => "Palestinian Territories","PA" => "Panama","PZ" => "Panama Canal Zone","PG" => "Papua New Guinea","PY" => "Paraguay","YD" => "People's Democratic Republic of Yemen","PE" => "Peru","PH" => "Philippines","PN" => "Pitcairn Islands","PL" => "Poland","PT" => "Portugal","PR" => "Puerto Rico","QA" => "Qatar","RO" => "Romania","RU" => "Russia","RW" => "Rwanda","RE" => "Réunion","BL" => "Saint Barthélemy","SH" => "Saint Helena","KN" => "Saint Kitts and Nevis","LC" => "Saint Lucia","MF" => "Saint Martin","PM" => "Saint Pierre and Miquelon","VC" => "Saint Vincent and the Grenadines","WS" => "Samoa","SM" => "San Marino","SA" => "Saudi Arabia","SN" => "Senegal","RS" => "Serbia","CS" => "Serbia and Montenegro","SC" => "Seychelles","SL" => "Sierra Leone","SG" => "Singapore","SK" => "Slovakia","SI" => "Slovenia","SB" => "Solomon Islands","SO" => "Somalia","ZA" => "South Africa","GS" => "South Georgia and the South Sandwich Islands","KR" => "South Korea","ES" => "Spain","LK" => "Sri Lanka","SD" => "Sudan","SR" => "Suriname","SJ" => "Svalbard and Jan Mayen","SZ" => "Swaziland","SE" => "Sweden","CH" => "Switzerland","SY" => "Syria","ST" => "São Tomé and Príncipe","TW" => "Taiwan","TJ" => "Tajikistan","TZ" => "Tanzania","TH" => "Thailand","TL" => "Timor-Leste","TG" => "Togo","TK" => "Tokelau","TO" => "Tonga","TT" => "Trinidad and Tobago","TN" => "Tunisia","TR" => "Turkey","TM" => "Turkmenistan","TC" => "Turks and Caicos Islands","TV" => "Tuvalu","UM" => "U.S. Minor Outlying Islands","PU" => "U.S. Miscellaneous Pacific Islands","VI" => "U.S. Virgin Islands","UG" => "Uganda","UA" => "Ukraine","SU" => "Union of Soviet Socialist Republics","AE" => "United Arab Emirates","GB" => "United Kingdom","US" => "United States","ZZ" => "Unknown or Invalid Region","UY" => "Uruguay","UZ" => "Uzbekistan","VU" => "Vanuatu","VA" => "Vatican City","VE" => "Venezuela","VN" => "Vietnam","WK" => "Wake Island","WF" => "Wallis and Futuna","EH" => "Western Sahara","YE" => "Yemen","ZM" => "Zambia","ZW" => "Zimbabwe","AX" => "Åland Islands",); ?>
                                @foreach ($countries as $code => $country)
                                    <option value="{{ $code }}" {{ $code === old('country') ? 'selected' : '' }}>{{ $country }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="icon is-small is-left">
                            <i class="fa fa-globe"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <div class="control has-icons-left has-icons-right">
                        <input v-model="location" type="text" class="input" :class="{'is-success': fields.location &amp;&amp; fields.location.valid, 'is-danger': errors.has('location')}" name="location" placeholder="Location" v-validate="'alpha_spaces'" value="{{ old('location') }}">
                        <span class="icon is-small is-left">
                            <i class="fa fa-map-marker"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class="fa" :class="{'fa-check': fields.location &amp;&amp; fields.location.valid, 'fa-warning': errors.has('location')}"></i>
                        </span>
                    </div>
                </div>
                <!-- End Country -->

                <!-- Avatar -->
                <p class="is-size-5-desktop is-size-6-touch has-text-weight-light m-t-15 m-b-5">Your <b class="has-text-weight-normal">profile picture</b> will be visible to anyone who views your profile.</p>
                <div class="file has-name is-fullwidth">
                    <label class="file-label">
                        <input class="file-input" type="file" name="avatar" accept="image/x-png,image/jpeg">
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fa fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Choose a file…
                            </span>
                        </span>
                        <span class="file-name">
                            Image must be `.jpeg/.jpg/.png` and have a 1:1 aspect ratio.
                        </span>
                    </label>
                </div>
                <!-- End Avatar -->

                <!-- Form Footer -->
                <div class="form-footer">
                    <hr>
                    <button type="submit" class="button is-medium is-primary is-pulled-right is-fullwidth" :disabled="submittable == 0" style="margin-bottom: 1.5rem;">Create Profile</button>
                </div>
                <!-- End Form Footer -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '.form-wrapper',
            data: {
                name: "",
                nameAvailable: true,
                nameLoading: false,
                link: "",
                linkAvailable: true,
                linkLoading: false,
                displayName: "",
                motto: "",
                location: "",
                submittable: false
            },
            watch: {
                name: function() {
                    this.nameLoading = true;
                    if (!this.errors.has('name')) {
                        this.checkName();
                    } else {
                        this.nameLoading = false;
                    }
                    this.openSesame();
                },
                link: function() {
                    this.linkLoading = true;
                    if (!this.errors.has('link')) {
                        this.checkLink();
                    } else {
                        this.linkLoading = false;
                    }
                    this.openSesame();
                },
                displayName: function() {
                    this.openSesame();
                },
                motto: function() {
                    this.openSesame();
                },
                location: function() {
                    this.openSesame();
                }
            },
            methods: {
                checkLink: _.debounce(function() {
                    let app = this;
                    app.linkAvailable = true;
                    axios.post('{{ route('profile.check.link') }}', {api_token: "{{ Auth::user()->api_token }}", value: app.link})
                    .then(function (response) {
                        app.linkLoading = false;
                        app.linkAvailable = response.data;
                        app.openSesame();
                    })
                    .catch(function (error) {
                        console.log(error);
                        app.linkLoading = false;
                        app.linkAvailable = true;
                        app.openSesame();
                    });
                }, 1000),
                checkName: _.debounce(function() {
                    let app = this;
                    app.nameAvailable = true;
                    axios.post('{{ route('profile.check.name') }}', {api_token: "{{ Auth::user()->api_token }}", value: app.name})
                    .then(function (response) {
                        app.nameLoading = false;
                        app.nameAvailable = response.data;
                        app.openSesame();
                    })
                    .catch(function (error) {
                        console.log(error);
                        app.nameLoading = false;
                        app.nameAvailable = true;
                        app.openSesame();
                    });
                }, 1000),
                openSesame: _.debounce(function() {
                    var errors = this.errors.has('name') || !this.linkAvailable || !this.nameAvailable || this.errors.has('displayName') || this.errors.has('name') || this.errors.has('link') || this.errors.has('location') || this.errors.has('motto');
                    var length = this.name.length > 0 && this.link.length > 0 && this.displayName.length > 0;
                    this.submittable = !errors && length;
                }, 250)
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('input[type="file"]').on('change', function(e) {
                var sibs = $(this).siblings('span');
                $(sibs[1]).html(e.target.files[0].name);
            });
        });
    </script>
@endsection

<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>


    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10 w-full bg-blue-100">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-white hover:bg-blue-700 py-3 px-5 rounded-lg  bg-blue-500 focus:outline focus:outline-2 focus:rounded-lg focus:outline-blue-800">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="font-semibold text-white bg-green-600 px-5 py-3 rounded-lg hover:bg-green-700 focus:outline focus:outline-2 focus:rounded-lg focus:outline-green-800">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold bg-violet-500 hover:bg-violet-700 text-white py-3 px-5 rounded-lg focus:outline focus:outline-2 focus:rounded-lg focus:outline-violet-800">Register</Link>
            </template>
        </div>
        <div class="shadow-lg">
            <div>
            <h1 class="text-5xl text-center font-semibold py-3 px-5 text-violet-600 shadow-lg">Teachers Wellfare Trust</h1>
        </div>
           <img class="rounded-lg" :src="'/4.jpg'" alt="">
           <!-- <h1>সরকারি প্রাথমিক বিদ্যালয় শিক্ষক কল্যাণ ট্রাস্ট</h1> -->
        </div>

    </div>
 <footer class="flex justify-between">
            <div class="footer_content links w-full flex-wrap justify-center items-center">
                <h4 class="heading">গুরুত্বপূর্ণ লিঙ্ক</h4>
                <div class="site_link text-white">
                    <ul>
                        <li><a target="_blank" noopener norefferer href="https://bangabhaban.gov.bd">রাষ্ট্রপতির কার্যালয়</a></li>
                        <li><a target="_blank" noopener norefferer href="https://pmo.gov.bd/">প্রধানমন্ত্রীর কার্যালয়</a></li>
                        <li><a target="_blank" noopener norefferer href="http://www.parliament.gov.bd/">জাতীয় সংসদ</a></li>
                        <li><a target="_blank" noopener norefferer href="https://mopa.gov.bd/">জনপ্রশাসন মন্ত্রণালয়</a></li>
                        <li><a target="_blank" noopener norefferer href="https://bangladesh.gov.bd">জাতীয় তথ্য বাতায়ন</a></li>
                        <li><a target="_blank" noopener norefferer href="https://www.courseminded.com/tools">আরটিআই অনলাইন প্রশিক্ষণ</a></li>
                        <li><a target="_blank" noopener norefferer href="http://services.portal.gov.bd/">সেবাকুঞ্জ</a></li>
                        <li><a target="_blank" noopener norefferer href="http://forms.mygov.bd/">ফরমস পোর্টাল</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer_content hotline w-full">
                <h4 class="heading">হেল্পলাইন</h4>
                <div class="helpline text-white">
                    <ul>
                        <li><span>দুদক</span><a href="tel:106">১০৬</a></li>
                        <li><span>জরুরি সেবা</span><a href="tel:999">৯৯৯</a></li>
                        <li><span>নাগরিক সেবা</span><a href="tel:333">৩৩৩</a></li>
                        <li><span>শিশু সহায়তা</span><a href="tel:1098">১০৯৮</a></li>
                        <li><span>নারী ও শিশু নির্যাতন প্রতিরোধ</span><a href="tel:109">১০৯</a></li>
                    </ul>
                </div>
            </div>
        </footer>

        <div class="copyright_area">
            <span>২০২৩ &copy; অটোমেট ইনফোসিস</span>
        </div>
</template>

<style>
@media (max-width: 1150px) {


}
/* Medium Layout: 1280px. */
@media (max-width: 992px) {

	footer {
	    grid-template-columns: 1fr 1fr;
	}

}
/* Tablet Layout: 768px. */
@media (max-width: 768px) {

	.footer_content.links {
	    order: 0;
	}
	.footer_content.hotline {
	    order: 1;
	}
	.footer_content.comment {
	    order: 2;
	    grid-column: 1 / -1;
	}

}
/* Mobile Layout: 320px. */
@media (max-width: 600px) {

    footer {
	    padding: 35px 15px;
	}


}
/* Mobile Layout: 320px. */
@media (max-width: 480px) {

	.heading {
	    margin-bottom: 15px;
	    letter-spacing: 0;
	}

}


.heading {
    margin-bottom: 25px;
    letter-spacing: 2px;
}
footer {
    padding: 50px;
    background: #273443;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    grid-gap: 1.5rem;
}
footer a {
    text-decoration: none;
    color: var(--light-color);
}
footer a:hover {
    text-decoration: underline;
    color: var(--light-color);
}
.footer_content h4 {
    color: #b0bfb6;
}
.footer_content .heading {
    margin-bottom: 20px;
}
.helpline ul li span {
    margin-right: 30px;
    color: var(--light-color);
}
.copyright_area {
    background: #202f2f;
    padding: 10px 0;
    color: #b0bfb6;
    text-align: center;
}

</style>

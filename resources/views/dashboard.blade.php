@extends('layouts.app')

@section('title', 'Dashboard')

{{--@section('header')
<h2 class="font-semibold text-xl text-gray-800 dark:text-white-200 leading-tight">
    {{ __('Dashboard') }}
</h2>
@endsection--}}

@section('content')

<div class="py-0 flex justify-center items-center">
    <div id="cardBody" class="max-w-md mx-auto sm:px-6 lg:px-8 fixed top-1 w-full" style="display: none;">
        <div role="alert"
            class="alert flex items-center justify-center bg-white border border-gray-300 rounded-lg shadow-lg p-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-center">Hola {{ Auth::user()->name }} ¡Bienvenido al Sistema!</span>
        </div>
    </div>
</div>

{{--<main class="grid card rounded-box place-items-center mt-2">--}}
    <div class="flex flex-col w-full lg:flex-row lg:space-y-0 mt-1">
        <div class="lg:w-3/4">
            <div
                class="grid flex-grow card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-1 lg:ml-0 lg:mr-2">
                Muestra el carrito de Productos
                <h2>Este sera el carrito de compras para los productos agregadops al</h2><br><br>
                <p>ahdkjhaskdhsakdhaskjdaskjh
                    dajkshdkjashdkjashjk
                    asdasdasfdasfadsfafaf
                    asfasfasfasfasfafa
                    asfasfasfasfasfafafdasfasfasdfas
                    dasdfa
                    askdjhaskhdfaskujihdfuioaghfu
                    idghysaEUIFRTGYaseufgasdu
                    asdfjasgfjyhagsdjfyhugayujdg
                    asujygdfasujygfujahysg
                    asjfdgasyhgfdauystgdfuyastg
                    dfuyiagsfuiydgasuyifgasuyigtf
                    safdjyagfuydgasuyifdgasu iygfdui
                    aysgfduiyagsuyidftgasuyifga
                    adashdkjhak
                    asdhnasjkdhask
                    asdjhgbasjkdbgsak
                    asdbfvasjhngdfvasjhn
                    adfcmhasgjdhabg
                    asdhjmagbdjfhbag
                    asdjbhasjkbdfgasjk
                    asjmdhgbaskujdga
                    asdjmhbaskdg
                    asjkdhaskjdha
                    askjmdhasjkhb
                    yusigdf3HIRHJDWAQOIPRHJDEOIQA
                    ASEFURFDYATWE7URFDGTAUIYDFGTAUYIT GD
                    FUYATGDFUYGATUegfuywesgtfyuwesgtuyf
                    fsufygsduyfguyfgsuygfhsuygfyu f
                    suybhfuis fsuifb suibfhujsbfuhs fsufb suh
                    sfj sffsuybfyubsfugfsuyi
                    gfuiaghfuishgfuihgsfieuhgfiugh
                    sfsuhgfuysghfiushgfiush diufhsiufhsiuh
                    fgisudhgiuhdgfiushiufgvhsdiuhgf
                    sdfusydgfhuysidgfvu8yshfuysghfuygshuyf f
                    suy sfuf usyfbfysu fsy
                    vbfsubyufsfus yusfvbsu fsuyfb
                    s fsusfyfsvbysyu8bfvsuyg
                    fuiysghfiushgiufhgbsiufhsiu
                    sdfvshbuyfvsufusbfusbhfuiyshgfuish
                    uifyhsuyigfhusyihRHJDWAQOIPRHJDEOIQA
                    yfsdufyihsguiyfghsuyfghsuygfusgfuys
                    fuygsuyfghsuiyghf
                    uisghfiusghifughsuifghsu8i
                    sdfhgsuiygfhsuigfusgfuishufyi
                    sfduyfgbs
                    uygfusyghfusiyghfuis
                    yhgfuisy fsujfgsuyfgusygfuysgu
                    sdfgsygfusyghfuisgy
                    hfuishgiu sfuysguyfgsuyf
                    gsuyigfsuigfhuisghf
                    sfuysfgufgusygfuysgfuygs
                    syugfuysgfuysgufyhsuiyfghsuifgsugfu
                </p>
                <p>
                    afaghfdghaj adsjhsgbdahjgbd
                    asgdjhasgdjhgahj
                    askdjhaskuhdaksjhdkjas
                    asdjkashgdujkgahsjdhgsa
                    akhsdkujhsajdkasjd
                    asdkghawdugyhqwuigqeuwi
                    adfsiujfdghaiughdfjaksgd
                    adfiuhfidugyhaqwiudrfghyauifdh
                    asdfkasuhdkashdjkasg
                    adfaghsjdgawsjhdgashj
                    afsjgfujyasgfdjhagsdjh
                    asjdgayujasdgjyhdsgjyhd
                    asasjgdfjayhsgdjhas
                    asdjdgasyjhugdasyhj
                    asdfgajydgfasjyh
                    asyfdgasyujgdfasjyhgdf
                    asjghdhajsfdhas
                    aasgfdhasfdh
                </p>
            </div>
        </div>
        <!--div class="divider lg:divider-horizontal"></div-->
        <div class="lg:w-1/4">
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                contenido de la segunda columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la tercera columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la cuarta columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la quinta columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la tercera columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la cuarta columna

            </div>
            <div
                class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center mb-1 ml-2 lg:mb-2 lg:ml-0 lg:mr-2">
                Contenido de la quinta columna

            </div>
            
        </div>
    </div>
{{--</main>--}}
@endsection
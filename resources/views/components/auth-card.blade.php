<div class="flex flex-col items-center pt-6 min-h-screen sm:justify-center sm:pt-0 bg-slate-950">
    <div>
        <h1 x-data="{
             startingAnimation: { opacity: 0, scale: 4 },
            endingAnimation: { opacity: 1, scale: 1, stagger: 0.07, duration: 1, ease: 'expo.out' },
            addCNDScript: true,
            animateText() {
                $el.classList.remove('invisible');
                gsap.fromTo($el.children, this.startingAnimation, this.endingAnimation);
            },
            splitCharactersIntoSpans(element) {
                text = element.innerHTML;
                modifiedHTML = [];
                for (var i = 0; i < text.length; i++) {
                    attributes = '';
                    if(text[i].trim()){ attributes = 'class=\'inline-block\''; }
                    modifiedHTML.push('<span ' + attributes + '>' + text[i] + '</span>');
                }
                element.innerHTML = modifiedHTML.join('');
            },
            addScriptToHead(url) {
                script = document.createElement('script');
                script.src = url;
                document.head.appendChild(script);
            }
        }"
            x-init="
            splitCharactersIntoSpans($el);
            if(addCNDScript){
                addScriptToHead('https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js');
            }
            gsapInterval = setInterval(function(){
                if(typeof gsap !== 'undefined'){
                    animateText();
                    clearInterval(gsapInterval);
                }
            }, 5);
        "
            class="block invisible text-3xl font-bold custom-font"
        >
            {{ ucwords(config('app.name')) }}
        </h1>
    </div>
    
    <div class="overflow-hidden py-4 px-6 mt-6 w-full shadow-md sm:max-w-md sm:rounded-lg bg-slate-900">
        {{ $slot }}
    </div>
    <div class="mt-2">
        <a href="https://www.dezinehq.com"
           class="text-xs font-extrabold text-slate-700"
        >powered by Dezine HQ</a>
    </div>
</div>

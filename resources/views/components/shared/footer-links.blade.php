@props(['showContact' => false])

<div class="flex flex-wrap justify-center gap-6">
    <a class="font-label-md text-label-md text-on-surface-variant transition-colors hover:text-primary hover:underline" href="#">Privacy Policy</a>
    <a class="font-label-md text-label-md text-on-surface-variant transition-colors hover:text-primary hover:underline" href="#">Terms of Service</a>
    <a class="font-label-md text-label-md text-on-surface-variant transition-colors hover:text-primary hover:underline" href="#">Help Center</a>
    @if ($showContact)
        <a class="font-label-md text-label-md text-on-surface-variant transition-colors hover:text-primary hover:underline" href="#">Contact Us</a>
    @endif
</div>

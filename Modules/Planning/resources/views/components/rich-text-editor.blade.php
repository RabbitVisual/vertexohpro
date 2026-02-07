@props(['name', 'value' => '', 'placeholder' => ''])

<div wire:ignore>
    <div id="{{ $name }}-editor" class="h-48 border border-gray-300 rounded-lg">
        {!! $value !!}
    </div>
    <textarea id="{{ $name }}" name="{{ $name }}" class="hidden">{!! $value !!}</textarea>
</div>

@push('scripts')
    <script src="{{ asset('vendor/quill/quill.js') }}"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            const quill = new Quill('#{{ $name }}-editor', {
                theme: 'snow',
                placeholder: '{{ $placeholder }}',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });

            quill.on('text-change', function() {
                document.getElementById('{{ $name }}').value = quill.root.innerHTML;
                @this.set('{{ $name }}', quill.root.innerHTML);
            });
        });
    </script>
@endpush

@push('styles')
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
@endpush

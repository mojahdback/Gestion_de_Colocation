@props(['name','show'=>false,'maxWidth'=>'2xl'])
<div id="modal-{{ $name }}" style="display:{{ $show ? 'flex' : 'none' }};position:fixed;inset:0;background:rgba(28,28,28,0.5);z-index:100;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;border-radius:16px;padding:28px;width:100%;max-width:480px;box-shadow:0 20px 60px rgba(28,28,28,0.2);">
        {{ $slot }}
    </div>
</div>
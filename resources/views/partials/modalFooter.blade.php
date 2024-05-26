        </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">CERRAR</button>

                @if($selected_id < 1) <button type="button" wire:click.prevent="storeCategory()" class="btn btn-dark close-modal">
                    GUARDAR</button>

                    @else
                    <button type="button" wire:click.prevent="updateCategory()" class="btn btn-dark close-modal">ACTUALIZAR</button>
                    @endif

            </div>
        </div>
    </div>
</div>
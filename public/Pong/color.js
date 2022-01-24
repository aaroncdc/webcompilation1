o the climbing action.
Pl_SetClimbAction:
	xor  a
	ld   [sPlTimer], a
	ld   [sPlJumpYPathIndex], a
	ld   a, PL_ACT_CLIMB
	ld   [sPlAction], a
	ld   a, $01
	ld   [sPlNewAction], a
	; Set the correct climb frame
	ld   a, OBJ_WARIO_CLIMB0
	ld   [sPlLstId], a
	ld   a, [sSmallWario]
	and  a
	ret  z
	ld   a, [sPlLstId]
	add  OBJ_SMALLWARIO_CLIMB0-OBJ_WARIO_CLIMB0
	ld   [sPlLstId], a
	ret
; =============== Pl_DoCtrl_Stand_CheckB ===============
; Checks the action mapped to the B button.
Pl_DoCtrl_Stand_CheckB:
	ld   a, [sPlLstId]
	cp   a, OBJ_WARIO_HOLD			; Holding something?
	jr   z, .checkDownLadder		; If so, ignore
	
	; Can't be a jump since we don't necessarily trigger any action in Pl_StartActionB
	ldh  a, [hJoyNewKeys]
	bit  KEYB_B, a					; Pressed B?
	call nz, Pl_StartActionB		; If so, jump
	
	; But if we triggered one, ignore everything else
	ld   a, [sPlNewAction]
	and  a
	ret  nz
	
; Checks if we're starting to climb down a ladder.
.checkDownLadder:
	ldh  a, [hJoyKeys]
	bit  KEYB_DOWN, a			
	jr   z, .checkA
	;--
	; If there's a ladder below, grab it
	call PlBGColi
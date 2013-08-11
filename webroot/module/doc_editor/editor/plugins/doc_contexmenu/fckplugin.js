var doc_ContextMenu_Listener = [
{   //��ѡ��
    AddItems : function( menu, tag, tagName ) {
		if ( tagName == 'INPUT' && tag.type == 'checkbox' )
		{
			menu.AddSeparator() ;
			menu.AddItem( 'doc_checkbox', '��ѡ������', 49 ) ;
		}
	}
},
{
	AddItems : function( menu, tag, tagName ) {
		menu.AddItem( 'doc_delete'	, FCKLang.doc_delete	, 100, FCKCommands.GetCommand( 'doc_delete' ).GetState() == FCK_TRISTATE_DISABLED ) ;
        //menu.AddItem( 'SelectAll', FCKLang.doc_SelectAll , 100, FCKCommands.GetCommand( 'SelectAll' ).GetState() == FCK_TRISTATE_DISABLED ) ; 
    }
},
{
	AddItems : function( menu, tag, tagName )
	{
		if ( tagName == 'INPUT' && tag.type == 'text' )
		{
			menu.AddSeparator() ;
            menu.AddItem( 'doc_textfield', '�������������', 51 ) ;

		}
	}
},
{
	AddItems : function( menu, tag, tagName )
	{
		if ( tagName == 'TEXTAREA' )
		{
			menu.AddSeparator() ;
			menu.AddItem( 'doc_textarea', '�������������', 52 ) ;
		}
	}
}
];


for ( var i = 0 ; i < doc_ContextMenu_Listener.length ; i++ )
{
	FCK.ContextMenu.RegisterListener(doc_ContextMenu_Listener[i]) ;
}


//��ӡ�ɾ���ؼ����˵���
var FCKDeleteCommand = function()
{
	this.Name = 'doc_delete' ;
}

FCKDeleteCommand.prototype =
{
	Execute : function()
	{
		var enabled = false ;

        //ɾ���ؼ�ʱ������ʾ  add by lx 20090928 
        var cntrlSelected = FCKSelection.GetSelectedElement();
        if(cntrlSelected != null)
        {
            var cntrlClassName = cntrlSelected.className.toUpperCase();
            var cntrlTagName = cntrlSelected.tagName.toUpperCase();
            if(cntrlTagName == "INPUT" || cntrlTagName == "TEXTAREA" || cntrlTagName == "SELECT")
            {
                var msg = "ȷ��Ҫɾ���ؼ���ɾ���ؼ����ܵ�����ʷ�����޷���ʾ��ȷ��Ҫ������";
                if(!window.confirm(msg))
                    return false;
            } 
        }
    
	    if ( FCKBrowserInfo.IsIE )
	    {
	    	var onEvent = function()
	    	{
	    		enabled = true ;
	    	} ;
    
	    	var eventName = 'on' + this.Name.toLowerCase() ;
    
	    	FCK.EditorDocument.body.attachEvent( eventName, onEvent ) ;
	    	FCK.ExecuteNamedCommand( 'Delete' ) ;
	    	FCK.EditorDocument.body.detachEvent( eventName, onEvent ) ;
	    }
	    else
	    {
	    	try
	    	{
	    		FCK.ExecuteNamedCommand( this.Name ) ;
	    		enabled = true ;
	    	}
	    	catch(e){}
	    }
	},

	GetState : function()
	{
		return FCK.EditMode != FCK_EDITMODE_WYSIWYG ?
				FCK_TRISTATE_DISABLED :
				FCK.GetNamedCommandState( 'Cut' ) ;
	}
};

FCKCommands.RegisterCommand( 'doc_delete',new FCKDeleteCommand ( 'doc_delete', 'ɾ���ؼ�') );
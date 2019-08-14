/**
 * @author    Marcin Frymark
 * @email     contact@alekseon.com
 * @company   Alekseon
 * @website   www.alekseon.com
 */
var CustomerComment = Class.create();
CustomerComment.prototype = {

    initialize: function(saveUrl, deleteUrl, customerCommentContainer, deleteConfirmationMessage) {
        this.onSave  = this.saveSuccess.bindAsEventListener(this);
        this.onFailure = this.saveFailure.bindAsEventListener(this);
        this.form = $('customer_comment_edit');
        this.saveUrl = saveUrl;
        this.deleteUrl = deleteUrl;
        this.customerCommentContainer = customerCommentContainer;
        this.deleteConfirmationMessage = deleteConfirmationMessage;
    },
    
    editComment: function() {
        $('customer_comment').hide();
        $('customer_comment_edit').show();        
    },

    changeCommentType: function(select) {
        var newType = select.options[select.selectedIndex].getAttribute('typeclass');
        $('customer_comment_edit').setAttribute('class', '');
        $('customer_comment_edit').addClassName(newType);
    },
    
    cancelEdition: function() {
        $('customer_comment_edit').hide();
        $('customer_comment').show();
    },
    
    saveComment: function() {
        var request = new Ajax.Request(
            this.saveUrl,
            {
                loaderArea: true,
                method: 'post',
                onComplete: '',
                onSuccess: this.onSave,
                onFailure: this.onFailure,
                evalScripts: true,
                parameters: Form.serialize(this.form)
            }
        );
    },
    
    deleteComment: function() {
        var confirmation = confirm(this.deleteConfirmationMessage);

        if (confirmation) {
            var request = new Ajax.Request(
                this.deleteUrl,
                {
                    loaderArea: true,
                    method: 'post',
                    onComplete: '',
                    onSuccess: this.onSave,
                    onFailure: this.onFailure,
                    evalScripts: true,
                    parameters: Form.serialize(this.form)
                }
            );
        }
    },
    
    saveSuccess: function(transport) {
        var response = false;
        var commentBlockHtml = false;

        if (transport.responseText) {
            response = eval('(' + transport.responseText + ')');
            commentBlockHtml = response.commentBlockHtml;
        }

        if (commentBlockHtml) {
            this.customerCommentContainer.innerHTML = commentBlockHtml;
            this.form = $('customer_comment_edit');
        } else {
            alert(response.errorMsg);
        }
    },
    
    saveFailure: function(transport){
        alert(this.failureMsg);
    }  
}
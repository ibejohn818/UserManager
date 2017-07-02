<?php 

namespace UserManager\View\Helper;

use Cake\View\Helper;
use Cake\Event\Event;
use UserManager\Model\Entity\UserAccountCustomField;
use UserManager\Model\Entity\UserAccountCustomFieldValue;
use Cake\ORM\TableRegistry;

class UserManagerHelper extends Helper {

    public $helpers = [
		'Form',
		'Html',
		'Session',
		'Url'

    ];

	/**
	 * Check if the user is logged in
	 * @return bool return true if the user is logged in and false if not
	 */
	public function isLoggedIn() {
        return $this->request->session()->check("Auth.User.id");
    }

    public function user($key = false) {

        if (!$key) {
            $key = "Auth.User";
        } else {
            $key = "Auth.User.{$key}";
        }

        return $this->request->session()->read($key);

	}


	public function authorizeBtn($type,$label,$uri,$ops = []) {
		if(!isset($ops['class'])) {
			$ops['class'] = '';
		}
		$ops['class'] = " btn  btn-{$type}";

		return $this->authorizeLink($label,$uri,$ops);

	}

    public function authorizeLink($label,$uri,$ops = []) {

        $uri = $this->authorizeUri($uri);

        if(!$uri) {
            return false;
        }

		if(isset($ops['icon'])) {
			$icon = "<i class='fa {$ops['icon']}'></i>";
			$ops['escape'] = false;
			$label = "{$icon} {$label}";
			unset($ops['icon']);
		}

        return $this->Html->link($label,$uri,$ops);

    }

    public function authorizeUri(array $uri) {

        if(!$this->isLoggedIn()) {
            return false;
        }

        $UserPermissions = TableRegistry::get("UserManager.UserAccountPermissions");

        $Prefix = (isset($uri['prefix'])) ? $uri['prefix']:false;
        $Controller = (isset($uri['controller'])) ? $uri['controller']:false;
        $Action = (isset($uri['action'])) ? $uri['action']:false;
        $Plugin = (isset($uri['plugin'])) ? $uri['plugin']:false;

        $chk = $UserPermissions->parseUserPermission($this->user(),$Controller,$Action,$Plugin,$Prefix);

        if($chk) {
            return $this->Url->build($uri);
        }

        return false;

    }

    public function isMemberOfGroup($GroupIDs = []) {

        if(!is_array($GroupIDs)) {
            $GroupIDs = [$GroupIDs];
        }

        

    }
    public function customFieldEdit(UserAccountCustomField $field, UserAccountCustomFieldValue $value=null, $index = null) {

        $key = "";

        if(is_numeric($index)) {
            $key = ".{$index}.";
        }

        if(!$value) {
            $value = new UserAccountCustomFieldValue();
        }

        $html="";

		$field_value = $value->field_value;

		if(isset($this->request->data['user_account_custom_field_values'][$index]['field_value'])) {
			$field_value = $this->request->data['user_account_custom_field_values'][$index]['field_value'];
		}


        switch($field->field_type) {
            case "select":
                $options = [];
                $lines = explode("\n", $field->field_options);
                foreach($lines as $k=>$v) {
                    $vals = explode(":", $v);
                    $options[$vals[0]] = $vals[1];
                }
                $html = $this->Form->input("user_account_custom_field_values{$key}field_value",["options"=>$options,"label"=>$field->name,"selected"=>$field_value]);
            break;
            case "text":
                $html = $this->Form->input("user_account_custom_field_values{$key}field_value",["value"=>$field_value,"label"=>$field->name,'type'=>'text']);
            break;
            case "checkbox":
                $html = $this->Form->input("user_account_custom_field_values{$key}field_value",['type'=>'checkbox','label'=>$field->name,'checked'=>$field_value]);
            break;
            case "textarea":
                $html = $this->Form->input("user_account_custom_field_values{$key}field_value",['type'=>'textarea','label'=>$field->name,'value'=>$field_value]);
            break;
        }

        if(empty($value->id)) {
            $html .= $this->Form->input("user_account_custom_field_values{$key}user_account_id",['type'=>'hidden','value'=>$value->user_account_id]);
            $html .= $this->Form->input("user_account_custom_field_values{$key}user_account_custom_field_id",['type'=>'hidden','value'=>$field->id]);
        } else {
            $html .= $this->Form->input("user_account_custom_field_values{$key}id",['type'=>'hidden','value'=>$value->id]);
        }

		$html .= $this->Form->input("user_account_custom_field_values{$key}slug",['type'=>'hidden','value'=>$field->slug]);

        return $html;

    }

    public function beforeRender(Event $event) {
        
    }

    public function userImage() {

        
    }


}

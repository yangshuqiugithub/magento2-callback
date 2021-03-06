<?php

namespace Magenman\CallToOrder\Block\Adminhtml\Template\Edit;

/**
 * Class Form
 *
 * @package Magenman\CallToOrder\Block\Adminhtml\Manager\Edit
 */
class Form extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var
     */
    protected $_status;

    /**
     * Form constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('manager_form');
        $this->setTitle(__('CallToOrder Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magenman\CallToOrder\Model\Manager $model */
        $model = $this->_coreRegistry->registry('template');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post','enctype' => 'multipart/form-data']]
        );

        $form->setHtmlIdPrefix('calltoorder_');
        $id = $this->_request->getParam('id');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Add new template'), 'class' => 'fieldset-wide']
        );

        if (isset($id)) {
            $model['calltoorder_id'] = $id;
            $fieldset->addField('calltoorder_id', 'hidden', ['name' => 'calltoorder_id']);
        }

        $fieldset->addField(
            'template',
            'text',
            ['name' => 'template', 'label' => __('Template'), 'title' => __('Template'), 'required' => true]
        );
        $fieldset->addField(
            'subject',
            'textarea',
            ['name' => 'subject', 'label' => __('Content'), 'title' => __('Content'), 'required' => true]
        );
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}

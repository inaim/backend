UPGRADE FROM 1.2 to 1.3

Attribute:
* Method `AttributeId:fromKey` become deprecated, will be removed in future version
* The signature of constructor `ProductReadInheritedValuesByLanguageAction` has changed
* The signature of constructor `DbalCategoryCreatedEventProjector` has changed
* The signature of constructor `DbalValueAddedEventProjector` has changed
* The signature of constructor `DbalValueChangedEventProjector` has changed 
* The signature of constructor `DbalValueRemovedEventProjector` has changed
* The signature of constructor `DbalProductValueAddedEventProjector` has changed
* The signature of constructor `DbalProductValueChangedEventProjector` has changed
* The signature of constructor `DbalProductValueRemovedEventProjector` has changed
* The signature of constructor `ProductWorkflowQuery` has changed

Core
* `DownloaderInterface::download` throws exception rather than returning `null` value
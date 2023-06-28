# Customize System for Faster Development Manual

#### Test

## Table of Contents

- [Laravel](#laravel)
    - Eloquent
    - Query Builder
    - Pagination
    - Model
    - Relationship
    - Hooks
- [Vue](#vue)
    - Network
    - Slot
    - Props
    - Base table
    - View base table
    - Search Block
    - Watch
    - Validation
- [Tooling](#tooling)
    - Pint
- [Style](#style)
    - Laravel
    - Vue
    - MySQL
- [Ref](#ref)
    - Vue
    - Laravel
- [Package](#Package)



# Laravel:

####  Database
####  Order by a specific column data
```
 $query->orderByRaw("FIELD(status, 'Pending', 'Success')")
```

#### From date / To date:

###### Contain a single date:
```
// controller:
$startDate = $request->from_date ?? '1900-01-01';
$endDate = $request->to_date ?? now()->toDateString();
$query->whereBetween('notice_date', [$startDate, $endDate]);

// vue:
<div class="col-2">
    <div class="form-element">
        <input
        placeholder="From date"
        v-model="search_data.from_date"
        class="form-control form-control-sm shadow-none"
        type="text"
        onfocus="(this.type='date')"
        id="date"
        />
    </div>
</div>
<div class="col-2">
    <div class="form-element">
        <input
        placeholder="To Date"
        v-model="search_data.to_date"
        class="form-control form-control-sm shadow-none"
        type="text"
        onfocus="(this.type='date')"
        id="date"
        />
    </div>
</div>
```

###### Contain two date:
```
// controller:
 $startDate = $request->from_date ?? '1900-01-01';
        $endDate = $request->to_date ?? now()->toDateString();
        $query->whereDate('start_date', '>=', $startDate)
            ->whereDate('end_date', '<=', $endDate);
```


# Relationship

####  Belongs to:

```
return $this->belongsTo(Foo::class, 'foreign_key', 'owner_key');
return $this->belongsTo(Album::class, "album_id","id");
```

####  Has One:

```
return $this->hasOne(Foo::class, 'foreign_key', 'local_key');
return $this->hasOne(Slider::class, 'slider_id', 'id');
```

####  Has Many:

```
 return $this->hasMany(Foo::class, 'foreign_key', 'local_key');
 return $this->hasMany(Foo::class, 'slider_id', 'id');
```


####  Search on Relationship:

```
$query = Video::with('model')->whereHas('album', function ($query) use ($request) {
    $query->whereLike('name',$request->value );
})->oldest('sorting');

```

####  Image Upload:

```
if (!empty($thumbnail)) {
    $data['thumbnail'] = $this->upload($thumbnail, 'video', null, $base64 = false);
}
```

```
if (!empty($thumbnail)) {
    $data['thumbnail'] = $this->upload($thumbnail, 'video', null, $base64 = true);
} else {
    $data['thumbnail'] = $this->oldFile($video->thumbnail);
}
```

# Vue:


#### Add a extra button in base-table:

In your index page , inside created() put this code and modify it.

```
this.table.routes.array = [
      {
        title:"your tile",
        route: "your.route.index",
        icon: "home", // fa fa-[icon]
        class: "text-danger",
        isQuery: true, // create?id="id"
      },
    ];
```

#### Custom Add / Back button:

Inside the, template "create-form" , insert it [Your vue file] , and you can modify it via route.

```
  <create-form @onSubmit="submit">
<template v-slot:button>
      <AddOrBackButton
        :route="'slider' + '.index'"
        :portion="slider"
        :icon="'fas fa-backward'"
      />
    </template>
  <create-form @onSubmit="submit">

  <slot name="button">
              <AddOrBackButton
                :route="model + '.index'"
                :portion="model"
                :icon="'fas fa-backward'"
              />
            </slot>
```

#### Use Crop in Image:

####  In data():

```
data(){
    return{
        data:{
            image
        },
        image: { image: "" },
    }
}
```

####  In provide:

```
 provide() {
    return {
       data: () => this.data,
      image: this.image,
    };
  },

```

####  In store():

As we are using the cropper , we have to sent it through the 'this.data' property.

```
this.store(this.model,this.data,"route"); // Here, you can put your own route.
```

####  In Controller:

store()
```
$image = $request->image;
$this->upload($image, $path, null, $base64 = true);
```

update()

As from frontend you will recive the image as text not a file , that's why you have to check , if the image is text and same as in Database, then it is an old image.

```
if ($model->image !== $request->image) {
    $data['image'] = $this->upload($model->image, 'foo', $foo->image, $base64 = true);
} else {
    $data['image'] = $this->oldFile($model->image);
}
```

####  In Template

```

<!------------ Single Input ------------>
    <div class="row align-items-center">
      <File
        title="Slider"
        field="data.image"
        mime="img"
        fileClassName="file2"
        :req="true"
        :showCrop="true"
      />

<!------------ Single Input ------------>
 <GlobalCrop
        field="data.image"
        v-on:update:modelValue="data.image = $event"
        :image="image.image"
        :aspectRatio="{ aspectRatio: this.slider.width / this.slider.height }"
        :width="this.slider.width"
        :height="this.slider.height"
      ></GlobalCrop>
```


### Custom Select for Manual Dropdown:

####  In Template

```
<!------------ Single Input ------------>
<v-select-container title="Button type">
<select
    v-model="data.types"
    class="form-select shadow-none"
    aria-label="Default select example"
    required
>
    <template v-for="(type, index) in types" :key="index">
    <option value="" v-if="index === 0">-- Select --</option>
    <option :value="type">
        {{ type }}
    </option>
    </template>
</select>
</v-select-container>

data(){
  return{
    types: ["Staff", "Contractor", "Supplier"],
  }
}

```

####  In data()

```
data(){
    return{
        data:{
             button_type: "",
        }
    }
}
```


# Remove a specific button of base table:

create a variable and define the routes , then inject it in the data property inside table.

```
const routes = {
  view: "contact.show",
  destroy: "contact.destroy"
};

 table: {
        columns: tableColumns,
        routes: routes, // This.
        datas: [],
        meta: [],
        links: []
      }
```

#### View base Table:

View => ViewPage => ViewBaseTable

```
 data() {
    return {
      model: model,
      data: {},
      fields: ["id", "url"], // Which property of data you want to showcase.
      belongs_to: { // This one is responsible for relational data.
        data: {}, // Relational data.
        fields: ["name"], // Which property of data you want to showcase.
        model: "album", // This the model which will the url/route redirect.
      },
    };
  },

```


####  Filters:

####  enFormat()
You can use this global function to format the date as 11 May 2023 for consistency over the project.

```
$filter.enFormat(history.login_at) // created_at or updated_at
```

####  capitalize()

You can capitalize you word.

```
$filter.capitalize("sunday");
```

### Networking in Vue js:

### Global Function

####  get_data()

First parameter is for url, you can pass whatever you like. then second parameter is for data object, 
where you want to put the data after fetching it in your component.

```
get_data("url","data property");
```

####  callApi()

Call API is responsible for calling the API endpoint with data object. First parameter , is method "GET/POST/PUT/ANY" then your "url" , then the "dataObj"

```
callApi(method, url, dataObj = null) 
```

####  get_sorting()

To get the sorting of any model , you can use this function.
Namespace : 

```
get_sorting(namespace)

Example 01 : App\Models\Content will be like get_sorting("Content")",
Example 02: App\Models\Website\Content will be like get_sorting("Website-Content")
```

####  destroy_data()

This one is responsible for deleting a resource from the database.

```
destroy_data(model_name, id, search_data=null)
```

# Utility function:

####  scrollTop()

To modify the scroll behaviour.

```
 this.scrollTop(0, 0);
```

####  print()

Print the html content as pdf.

```
 this.print(elementId, documentTitle) 
 or 
 <button @click="print(elementId, documentTitle)"></button>
```

####  Disable Index page base table Button:

```
 <index-page :button="false"> </index-page>
```

####  Disable Base table action button:

```
methods:{
    injectCustomRoute() {
      this.table.routes.edit = null;
    },
},

    created()
{
     this.injectCustomRoute();
}
```

### Watch:

```
watch: {
    // Nested.
    "data.has_button"(current, old) {
      if (current == "No") {
        this.data.button_type = "";
      }
    },
  },
```

#### Validation:

## Vue.js

> Vue-Simple Validator `--https://simple-vue-validator.netlify.app/

####  A simple validation

```
"data.slider_id": function (value = null) {
      return Validator.value(value).required("Slider is required");
    },
```

####  A custom validation

```
"data.button_type": function (value = null) {
      const vm = this;
      return Validator.value(value).custom(function (value) {
        if (vm.data.has_button === "Yes") {
          vm.$toast("Button type is required", "warning");
        }
      });
    },
```

```
"data.button_type": function (value = null) {
      const vm = this;
      return Validator.value(value).custom(function (value) {
        if (vm.data.has_button === "Yes") {
          return "Button type is required";
        }
      });
    },
```

#### Mobile:
```
"data.mobile": function (value = null) {
      return Validator.value(value)
        .digit()
        .regex("01+[0-9+-]*$", "Must start with 01.")
        .minLength(11)
        .maxLength(11);
    },
```

####  Show validation error in template

```
 <span v-if="validation.hasError('data.category_id')" class="input-message text-danger">
    {{ validation.firstError("data.has_button") }}
</span>

```

####  Multiple search input in CSFD Vue

Ref: admin/index.vue

```
// In vue template:
<index-page>
    <!-- search field -->
    <template v-slot:search-field>
      <div class="col-lg-2">
        <select
          v-model="search_data.status"
          @change="search()"
          class="form-select shadow-none"
        >
          <option value="">All</option>
          <option value="active">Active</option>
          <option value="deactive">Deactive</option>
        </select>
      </div>
    </template>
  </index-page>

   search_data: {
        pagination: 10,
        field_name: "name",
        value: "",
        status: "active",
      },

// In controller:
  $query->whereAny('status', $request->status);
```

####  Advance Vue search:
ref: ``` activity/index.vue ```

#### Tooling:

* Code format:
Execute: ``` ./vendor/bin/pint ```

* Clean the activity log:
Execute: ``` php artisan activitylog:clean ```

* Create Model,Factory,Seeder:
Execute: ``` php artisan make:model Book -mfs ```

* Clear the cache:
Execute: ``` php artisan optimize:clear ```

#### Style Guide:

* Laravel:

    ######  PHP Rules:
     - Code style must follow PSR-1, PSR-2 and PSR-12.

    ######  Crud:
    - Try to keep controllers simple and stick to the default CRUD keywords (index, create, store, show, edit, update, destroy) 
    - Avoid something like "userCreate","userStore"

    ######  Strings:
    When possible prefer string interpolation above sprintf and the . operator.
    ```
    $notification = "welcome, {$name}.";
    ```

    ######  Ternary operators:
    Every portion of a ternary expression should be on its own line unless it's a really short expression.

    ```
    $result = $object instanceof Model ?
    $object->name :
   'A default value';
    ```

     ###### Route:

    - Public-facing urls must use kebab-case.
    - Route parameters should use camelCase.

    ```
    Route::get('user/create',[UserController::class,'index'])->name('user.create')
    Route::post('users',[UserController::class,'store'])->name('user.store')
    ```


#### Ref:
* Laravel:
* Vue:

#### Package:

| Package | README |
| ------ | ------ |
| Error | [https://github.com/Nogor-Solutions-Ltd/Error] |
| Activity Log | [https://github.com/spatie/laravel-activitylog] |

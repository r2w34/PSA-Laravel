<?php

// Script to create all model files for PSA Laravel application

$models = [
    'Coach' => [
        'fillable' => ['name', 'email', 'phone', 'specialization', 'experience', 'qualifications', 'is_active'],
        'casts' => ['is_active' => 'boolean'],
        'relationships' => [
            'batches' => 'hasMany:Batch'
        ]
    ],
    'Batch' => [
        'fillable' => ['name', 'sport_id', 'coach_id', 'schedule', 'max_capacity', 'current_capacity', 'skill_level', 'is_active'],
        'casts' => ['schedule' => 'array', 'is_active' => 'boolean'],
        'relationships' => [
            'sport' => 'belongsTo:Sport',
            'coach' => 'belongsTo:Coach',
            'students' => 'hasMany:Student',
            'attendance' => 'hasMany:Attendance'
        ]
    ],
    'Student' => [
        'fillable' => ['user_id', 'student_id', 'name', 'phone', 'email', 'date_of_birth', 'address', 'emergency_contact', 'medical_notes', 'sport_id', 'batch_id', 'skill_level', 'joining_date', 'is_active', 'profile_image_url'],
        'casts' => ['emergency_contact' => 'array', 'date_of_birth' => 'date', 'joining_date' => 'datetime', 'is_active' => 'boolean'],
        'relationships' => [
            'user' => 'belongsTo:User',
            'sport' => 'belongsTo:Sport',
            'batch' => 'belongsTo:Batch',
            'payments' => 'hasMany:Payment',
            'attendance' => 'hasMany:Attendance'
        ]
    ],
    'Payment' => [
        'fillable' => ['student_id', 'amount', 'payment_type', 'payment_method', 'status', 'transaction_id', 'receipt_number', 'payment_date', 'due_date', 'month_year', 'notes'],
        'casts' => ['amount' => 'decimal:2', 'payment_date' => 'datetime', 'due_date' => 'datetime'],
        'relationships' => [
            'student' => 'belongsTo:Student'
        ]
    ],
    'Attendance' => [
        'fillable' => ['student_id', 'batch_id', 'date', 'status', 'marked_by', 'marked_at', 'notes'],
        'casts' => ['date' => 'date', 'marked_at' => 'datetime'],
        'relationships' => [
            'student' => 'belongsTo:Student',
            'batch' => 'belongsTo:Batch',
            'markedBy' => 'belongsTo:User,marked_by'
        ]
    ],
    'Activity' => [
        'fillable' => ['type', 'description', 'user_id', 'entity_id', 'entity_type', 'metadata'],
        'casts' => ['metadata' => 'array'],
        'relationships' => [
            'user' => 'belongsTo:User'
        ]
    ],
    'Communication' => [
        'fillable' => ['type', 'recipient', 'message', 'status', 'sent_at', 'delivered_at', 'template_id', 'campaign_id', 'metadata'],
        'casts' => ['metadata' => 'array', 'sent_at' => 'datetime', 'delivered_at' => 'datetime'],
        'relationships' => []
    ],
    'Setting' => [
        'fillable' => ['category', 'key', 'value', 'description', 'is_active'],
        'casts' => ['value' => 'array', 'is_active' => 'boolean'],
        'relationships' => []
    ]
];

foreach ($models as $modelName => $config) {
    $fillableStr = "'" . implode("', '", $config['fillable']) . "'";
    
    $castsStr = '';
    if (!empty($config['casts'])) {
        $castsArray = [];
        foreach ($config['casts'] as $field => $cast) {
            $castsArray[] = "'$field' => '$cast'";
        }
        $castsStr = implode(",\n            ", $castsArray);
    }
    
    $relationshipsStr = '';
    if (!empty($config['relationships'])) {
        foreach ($config['relationships'] as $relationName => $relationDef) {
            list($type, $model) = explode(':', $relationDef);
            if (strpos($model, ',') !== false) {
                list($model, $foreignKey) = explode(',', $model);
                $relationshipsStr .= "\n    public function $relationName()\n    {\n        return \$this->$type($model::class, '$foreignKey');\n    }\n";
            } else {
                $relationshipsStr .= "\n    public function $relationName()\n    {\n        return \$this->$type($model::class);\n    }\n";
            }
        }
    }
    
    $modelContent = "<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class $modelName extends Model
{
    use HasFactory;

    protected \$fillable = [
        $fillableStr
    ];

    protected function casts(): array
    {
        return [
            $castsStr
        ];
    }
    $relationshipsStr
    // Scopes
    public function scopeActive(\$query)
    {
        return \$query->where('is_active', true);
    }
}
";
    
    file_put_contents("/workspace/psa-laravel/app/Models/$modelName.php", $modelContent);
    echo "Created $modelName model\n";
}

echo "All models created successfully!\n";
import { Link, useForm } from '@inertiajs/react';
import { useEffect, useState, useMemo } from 'react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    Box,
    ChakraProvider,
    defaultSystem,
    Input,
    Stack,
    Text,
    Textarea,
    Button,
    HStack,
    RadioGroup,
    NativeSelect,
} from '@chakra-ui/react';


const Edit = (props) => {

    // propsから、チーム・種目・ポジションを取得
    const { athlete, team_event_positions, sexes } = props;

    // 性別の登録情報を取得して、radioの値に設定
    const items = sexes.map(sex => ({
        label: sex.sex_name,
        value: String(sex.id), // Stringにしないとoptionタグで値が反映されない
    }));

    // useFormでフォームデータの状態(state)の管理
    const {data, setData, put, errors } = useForm({
        'athlete_id': athlete.id,
        'team_id': athlete.team.id,
        'team_name': athlete.team.team_name,
        'event_name': athlete.team.m_event.event_name,
        'm_event_position_id': athlete.m_event_position_id,
        'player_position_id': athlete.player_position_id,
        'athlete_name': athlete.name,
        'sex_id': String(athlete.sex.id),
        'birthday': athlete.birthday,
        'memo': athlete.memo
    });

    // フォームの入力内容が変更された際の処理
    const handleChange = (e) => {
        setData({ ...data, [e.target.name]: e.target.value });
    }

    // フォームが送信された際の処理
    const handleSubmit = (e) => {
        e.preventDefault();

        put(`/athletes/edit/${athlete.id}`, data);
    }

    return (
        <ChakraProvider value={defaultSystem}>

            <CustomHeader />

            {/* メイン */}
            <Box className='main' width='80%' m='auto' bg='white' marginTop='20px' p='6' boxShadow='md'>
                <Box textAlign='center' mb='6'>
                    <Text fontSize='25px' mb='2'>選手編集フォーム</Text>
                </Box>

                <Box as='form' onSubmit={handleSubmit}>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>チーム</Text>
                        <Input
                            type='text'
                            id='team_name'
                            name='team_name'
                            defaultValue={data.team_name}
                            readOnly={true}
                        />
                        {errors.team_name && <Text color='red.500'>{errors.team_name}</Text>}
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>種目</Text>
                        <Input
                            type='text'
                            id='m_event_name'
                            name='event_name'
                            defaultValue={data.event_name}
                            readOnly={true}
                        />
                        {errors.event_name && <Text color='red.500'>{errors.event_name}</Text>}
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>ポジション・階級</Text>
                        <NativeSelect.Root>
                            <NativeSelect.Field placeholder='ポジション・階級を選択してください' value={data.m_event_position_id} name='m_event_position_id' onChange={handleChange}>
                                {team_event_positions.map((positionOption, i) =>
                                    <option key={i} value={positionOption.id}>
                                        {positionOption.event_position_name}
                                    </option>
                                )}
                            </NativeSelect.Field>
                        </NativeSelect.Root>
                        {errors.m_event_position_id && <Text color='red.500'>{errors.m_event_position_id}</Text>}
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>選手名</Text>
                        <Input
                            placeholder='必須入力です'
                            type='text'
                            id='athlete_name'
                            name='athlete_name'
                            value={data.athlete_name}
                            onChange={handleChange}
                        />
                        {errors.athlete_name && <Text color='red.500'>{errors.athlete_name}</Text>}
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>性別</Text>
                        <RadioGroup.Root value={data.sex_id} name='sex_id' onChange={handleChange}>
                            <HStack gap="6">
                                {items.map((item) => (
                                    <RadioGroup.Item key={item.value} value={item.value}>
                                        <RadioGroup.ItemHiddenInput />
                                        <RadioGroup.ItemIndicator />
                                        <RadioGroup.ItemText>{item.label}</RadioGroup.ItemText>
                                    </RadioGroup.Item>
                                ))}
                            </HStack>
                        </RadioGroup.Root>
                        {errors.sex_id && <Text color='red.500'>{errors.sex_id}</Text>}
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>生年月日</Text>
                        <Input
                            placeholder='必須入力です'
                            type='date'
                            id='birthday'
                            name='birthday'
                            value={data.birthday}
                            onChange={handleChange}
                        />
                        {errors.birthday && <Text color='red.500'>{errors.birthday}</Text>}
                    </Stack>
                    <Stack gap="4" w="full" marginTop='1rem'>
                        <Text>メモ・備考</Text>
                        <Textarea
                            size="xl"
                            type="text"
                            id='memo'
                            name="memo"
                            value={data.memo}
                            onChange={handleChange}
                        />
                        {errors.memo && <Text color="red.500">{errors.memo}</Text>}
                    </Stack>
                    <HStack display='flex' justifyContent='center' gap='4' p='0.5rem' m='6'>
                        <Button as={Link} href={`/athletes`} color='white' bg='gray.500' size='lg' p='5' width='30%'>戻る</Button>
                        <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%'>更新</Button>
                    </HStack>
                </Box>
            </Box>
        </ChakraProvider>
    )
}

export default Edit;